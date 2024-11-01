<?php

namespace Modules\Subscriber\Http\Controllers;

use App\Country;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Program;
use Modules\Subscriber\Entities\Subscriber;
use Modules\Subscriber\Entities\SubscriberProgram;
use Modules\User\Entities\User;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Subscriber\Exports\SubscriberExport;
use Modules\Subscriber\Http\Requests\SubscriberRequest;
use Modules\Subscriber\Notifications\WelcomeNotification;
use Modules\Course\Entities\CourseFee;
use Exception;
use Modules\Lesson\Entities\LessonCompletion;
use PDF;

class SubscriberController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('subscriber.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Mobile No'),
            __('Email'),
            __('Country'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'subscriber_table',
            'source' => route('subscriber.list'),
            'data' => $data
        ];

        return view('subscriber::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('subscriber.view');
        set_time_limit(90);

        $canUpdate = auth()->user()->can('subscriber.update');
        $canDelete = auth()->user()->can('subscriber.delete');
        $builder = $this->getQuery();
        try {
            return $dataTables::of($builder)
                ->removeColumn('is_premium')
                ->editColumn('user_id', function ($item) {
                    $isPremium = $item->is_premium ? '<i class="mdi mdi-crown text-warning"></i>' : '';
                    $link = '<a href="#" class="modal-button" data-url="' . route('subscriber.program.hierarchy', $item->id) . '" data-toggle="modal">' . $item->user->name . ' ' . $isPremium . '</a>';
                    // return @$item->user->name . ' ' . $isPremium;
                    return $link;
                })
                ->addColumn('email', function ($item) {
                    return @$item->user->email;
                }, 3)
                ->editColumn('country_id', function ($item) {
                    return isset($item->country) ? $item->country->name : 'Unknown';
                })
                ->editColumn('deleted_at', function ($item) {
                    return statusSwitch($item->id, route("subscriber.change.status", $item->id), $item->deleted_at);
                })
                ->editColumn('created_at', function ($item) {
                    return showDate($item->created_at);
                })
                ->addColumn('action', function ($item) use ($canUpdate, $canDelete) {

                    $buttons = editButton(route("subscriber.edit", $item->id), $canUpdate, false);
                    $buttons .= deleteForm(route("subscriber.destroy", $item->id), $canDelete, true);
                    $buttons .= viewButton(route("subscriber.show", $item->id));
                    $em = $item->user->email;
                    $buttons .= "<button type='button' class='btn'  data-target-email='$em'  data-toggle='modal' data-target='#exampleModal'><i class='mdi mdi-gmail'></i></button>";

                    return $buttons;
                }, 7)
                ->rawColumns(range(0, 7))
                ->make(false);
        }catch (\Exception $e) {
            dd($e,$e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('subscriber.store');
        $countries = Country::all();
        $courses = [];
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('subscriber::subscriber', compact('action', 'countries', 'courses', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SubscriberRequest $request)
    {
        $this->authorize('subscriber.create');

        DB::beginTransaction();

        try {

            $password = generateRandomString();
            $filePath = uploads_files('fee_receipt');


            $user = new User;
            $user->name = $request->first_name . " " . $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($password);

            $user->save();

            $subscriber = new Subscriber;
            $subscriber->first_name = $request->first_name;
            $subscriber->last_name = $request->last_name;
            $subscriber->mobile_no = $request->mobile_no;
            $subscriber->country_id = $request->country;
            $subscriber->user_id = $user->id;

            $subscriber->save();


            foreach ($request->program as $key => $program) {

                $fee = $this->calculateFees($request, $key);
                $subscriberProgram = new SubscriberProgram;

                $subscriberProgram->subscriber_id = $subscriber->id;
                $subscriberProgram->program_id = $program;
                $subscriberProgram->receipt = isset($request->receipt[$key]) ? $this->uploadFile($request->receipt[$key], 'receipt_', 'receipt', $filePath) : NULL;

                $subscriberProgram->course_id = $request->course[$key];
                $subscriberProgram->course_fee_id = $request->package[$key];
                $subscriberProgram->start_date = $request->start_date[$key];

                $subscriberProgram->end_date = $request->end_date[$key];

                //$subscriberProgram->notes = $request->notes[$key];

                $subscriberProgram->fee = $fee;

                $subscriberProgram->save();
            }

            $user->notify(new WelcomeNotification($password));

            $this->logActivity(['activity' => sprintf('Subscriber created.'), 'id' => $subscriber->id], true, true);

            DB::commit();

            return $this->success(['redirection' => route('subscriber.edit', $subscriber->id)]);
        } catch (Exception $e) {

            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = Subscriber::with(['user', 'subscribePrograms'])->withCount('subscribeProgramsCount')->where('id', $id)->first();
        $lesson_mark = LessonCompletion::where('subscriber_id', $id)->get();
        return view('subscriber::view', compact('data', "lesson_mark"));
    }

    public function programHierarchy($id)
    {
        $data = Subscriber::with(['user', 'subscribePrograms'])->withCount('subscribeProgramsCount')->where('id', $id)->first();
        $lesson_mark = LessonCompletion::where('subscriber_id', $id)->get();
        return view("subscriber::hierarchy", compact('data', 'lesson_mark'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $courses = [];
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $action = route('subscriber.update', $id);
        $countries = Country::all();
        $subscriber = Subscriber::withTrashed()->findOrFail($id);
        return view('subscriber::subscriber', compact('action', 'countries', 'subscriber', 'courses', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SubscriberRequest $request, $id)
    {
        // dd($request->all());

        $this->authorize('subscriber.update');

        DB::beginTransaction();

        try {

            $filePath = uploads_files('fee_receipt');

            $subscriber = Subscriber::withTrashed()->findOrFail($id);
            $subscriber->first_name = $request->first_name;
            $subscriber->last_name = $request->last_name;
            $subscriber->mobile_no = $request->mobile_no;
            $subscriber->country_id = $request->country;
            $subscriber->save();

            $subscriberProgramId = $request->subscriber_program_id ?: [];

            SubscriberProgram::whereNotIn('id', $subscriberProgramId)->where('subscriber_id', $subscriber->id)->delete();

            foreach ($request->program as $key => $program) {

                $fee = $this->calculateFees($request, $key) ?? null;
 
                if ($request->subscriber_program_id && isset($request->subscriber_program_id[$key])) {
                    $subscriberProgram = SubscriberProgram::findOrFail($request->subscriber_program_id[$key]);
                } else {
                    $subscriberProgram = new SubscriberProgram;
                }

                $subscriberProgram->subscriber_id = $subscriber->id;
                $subscriberProgram->program_id = $program;
                
                $subscriberProgram->receipt = isset($request->receipt[$key]) ? $this->uploadFile($request->receipt[$key], 'receipt_', 'receipt', $filePath, $subscriberProgram) : $subscriberProgram->receipt;
                
                $subscriberProgram->course_id = $request->course[$key];
                $subscriberProgram->course_fee_id = $request->package[$key];
              
                $subscriberProgram->start_date = $request->start_date[$key];
                $subscriberProgram->end_date = $request->end_date[$key];
                 
                //$subscriberProgram->notes = isset($request->notes) ? $request->notes[$key] : '' ;
                 //dd($subscriberProgram);
                $subscriberProgram->fee = $fee;
                $subscriberProgram->save();
            }

            $user = $subscriber->user;
            $user->name = $request->first_name . " " . $request->last_name;
            $user->email = $request->email;
            $user->save();

            $this->logActivity(['activity' => sprintf('Subscriber updated.'), 'id' => $subscriber->id], true, true);

            DB::commit();

            return $this->success(['redirection' => route('subscriber.index')]);
        } catch (Exception $e) {
       
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('subscriber.update');

        DB::beginTransaction();

        try {

            $path = uploads_images('profile');
            $filePath = uploads_files('fee_receipt');

            $subscriber = Subscriber::withTrashed()->findOrFail($id);
            $subscriber->profile ? deleteFileIfExist($path . $subscriber->profile, true) : '';
            $subscriber->receipt ? deleteFileIfExist($filePath . $subscriber->receipt, true) : '';

            $subscriber->user->forceDelete();
            $subscriber->forceDelete();

            $this->logActivity(['activity' => sprintf('Subscriber deleted.'), 'id' => $subscriber->id], true, true);

            DB::commit();

            return $this->success(['redirection' => route('subscriber.index')]);
        } catch (Exception $e) {

            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    public function subscriberProgramlist(DataTables $dataTables, $id)
    {
        $this->authorize('subscriber.view');

        $canUpdate = auth()->user()->can('subscriber.update');
        $canDelete = auth()->user()->can('subscriber.delete');
        $builder = SubscriberProgram::select(['id', 'program_id', 'course_id', 'start_date', 'end_date'])->where('subscriber_id', $id);

        return $dataTables::of($builder)
            ->removeColumn('id')
            ->editColumn('program_id', function ($item) {
                return @$item->program->{'name' . withLocalization()};
            })
            ->addColumn('course_id', function ($item) {
                return @$item->course->{'name' . withLocalization()};
            }, 3)
            ->editColumn('start_date', function ($item) {
                return showDate($item->start_date);
            })
            ->editColumn('end_date', function ($item) {
                return showDate($item->end_date);
            })
            ->addColumn('fee', function ($item) {
                return @$item->course->sale_fee;
            })
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("subscriber.program.edit", $item->id), $canUpdate);
                $buttons .= deleteForm(route("subscriber.program.destroy", $item->id), $canDelete, true);

                return $buttons;
            }, 7)
            ->rawColumns(range(0, 7))
            ->make(false);
    }

    public function programCreate($id)
    {
        $action = route('subscriber.program.store', $id);
        $courses = [];
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $subscriber = $id;
        return view('subscriber::program.create', compact('action', 'courses', 'programs', 'subscriber'));
    }

    public function programStore(Request $request, $id)
    {
        $this->authorize('subscriber.create');

        $request->validate([
            'program' => 'required',
            'course' => 'required',
            'start_date' => 'nullable|required_with:end_date',
            'end_date' => 'nullable|required_with:start_date|after_or_equal:start_date',
            'user_id' => 'required'
        ], [
            'user_id.required' => __('Please create profile first.')
        ]);

        try {

            $subscriberProgram = new SubscriberProgram;
            $subscriberProgram->subscriber_id = $id;
            $subscriberProgram->program_id = $request->program;
            $subscriberProgram->course_id = $request->course;
            $subscriberProgram->start_date = $request->start_date;
            $subscriberProgram->end_date = $request->end_date;
            $subscriberProgram->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function programEdit($id)
    {
        $subscriberProgram = SubscriberProgram::findOrFail($id);
        $action = route('subscriber.program.update', $id);
        $courses = Course::whereHas('programs', function ($query) use ($subscriberProgram) {
            $query->where('program_id', $subscriberProgram->program_id);
        })->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $subscriber = $id;

        return view('subscriber::program.update', compact('action', 'courses', 'programs', 'subscriberProgram', 'subscriber'));
    }

    public function programUpdate(Request $request, $id)
    {
        $this->authorize('subscriber.create');

        $request->validate([
            'program' => 'required',
            'course' => 'required',
            'start_date' => 'nullable|required_with:end_date',
            'end_date' => 'nullable|required_with:start_date|after_or_equal:start_date',
            'user_id' => 'required'
        ], [
            'user_id.required' => __('Please create profile first.')
        ]);

        try {

            $subscriberProgram = SubscriberProgram::findOrFail($id);
            $subscriberProgram->program_id = $request->program;
            $subscriberProgram->course_id = $request->course;
            $subscriberProgram->start_date = $request->start_date;
            $subscriberProgram->end_date = $request->end_date;
            $subscriberProgram->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function programDestroy($id)
    {
        $this->authorize('subscriber.delete');

        try {

            $subscriberProgram = SubscriberProgram::findOrFail($id);
            $subscriberProgram->delete();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function filterForm()
    {
        $countries = Country::all();
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->withTrashed()->get();
        return view('subscriber::filter-form', compact('countries', 'programs'));
    }

    public function getQuery()
    {
        $request = request();
        $builder = Subscriber::select(['id', 'user_id', 'mobile_no', 'country_id', 'created_at', 'deleted_at', 'is_premium'])->withTrashed();

        $builder = $builder->whereHas('user', function ($query) use ($request) {
            if ($request->has('name') && !empty(trim($request->name))) {
                $query->where('name', 'LIKE', "%{$request->name}%");
            }

            if ($request->has('email') && !empty(trim($request->email))) {
                $query->where('email', 'LIKE', "%{$request->email}%");
            }
        });

        if ($request->has('mobile_no') && !empty(trim($request->mobile_no))) {
            $builder = $builder->where('mobile_no', 'LIKE', "%{$request->mobile_no}%");
        }

        if ($request->has('no_of_pur_program')) {

            $builder = $builder->withCount('subscribeProgramsCount');
        }
        if ($request->has('program')) {
            $builder = $builder->whereHas('subscribePrograms', function ($query) use ($request) {
                $query->whereIn('program_id', $request->program);
            });
        }

        if ($request->has('country')) {
            $builder = $builder->whereIn('country_id', $request->country);
        }

        // if ($request->has('from_date') && $request->has('end_date')) {
        //     $builder = $builder->whereHas('subscribePrograms', function ($query) use ($request) {
        //         $query->where('start_date', '>=', $request->from_date);
        //         $query->where('end_date', '<=', $request->to_date);
        //     });
        // }
        if ($request->has('from_date') && $request->has('to_date')  ) {
            // $builder = $builder->whereDateBetween('created_at', [$request->from_date, $request->to_date]);
            if(!empty($request->from_date) && empty($request->to_date)){
                $builder = $builder->where('created_at','>=', $request->from_date)
                    ->where('created_at', '<=', $request->to_date);
            }elseif(!empty($request->from_date)){
                $builder = $builder->where('created_at','>=', $request->from_date);
            }elseif(!empty($request->to_date)){
                $builder = $builder->where('created_at','>=', $request->to_date);
            }

        }

        if ($request->has('status')) {
            if (count($request->status) == 1) {
                $builder = in_array(1, $request->status) ? $builder->whereNull('deleted_at') : $builder->whereNotNull('deleted_at');
            }
        }

        return $builder;
    }

    public function exportExcel()
    {
        $this->authorize('subscriber.export');
        ini_set('max_execution_time', 300);
        $subscriber = $this->getQuery()->get();
        return Excel::download(new SubscriberExport($subscriber), 'Subscriber-Report.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportPDF()
    {
        $this->authorize('subscriber.export');
        
        ini_set('max_execution_time', 600); // Increase execution time
        ini_set('memory_limit', '1G');      // Increase memory limit for large data processing
    
        $subscribers = $this->getQuery()->cursor(); // Use cursor for efficient memory handling
    
        // Prepare the initial empty PDF view
        $pdf = PDF::loadView('subscriber::export', ['subscribers' => collect()]);
    
        // Start output buffer to build the PDF file incrementally
        $tempFilePath = storage_path('app/Subscriber-Report.pdf');
    
        // Open a file handle for writing PDF content to a temp file
        file_put_contents($tempFilePath, $pdf->output());
    
        // Use chunking to process and append subscribers in batches
        foreach ($subscribers as $subscriberBatch) {
            $pdfChunk = PDF::loadView('subscriber::export', ['subscribers' => $subscriberBatch]);
            file_put_contents($tempFilePath, $pdfChunk->output(), FILE_APPEND);
        }
    
        // Download the file after processing all batches
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }
    
    

    public function getByEmail(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $users = User::whereHas('subscriber')->where('email', 'LIKE', "%$search%")->select('id', 'name')->get();
        } else {
            $users = User::whereHas('subscriber')->select('id', 'name')->orderBy('id', 'desc')->limit(5)->get();
        }

        return response()->json($users->toArray());
    }

    public function changeStatus($id)
    {
        $this->authorize('subscriber.delete');

        try {
            $subscriber = Subscriber::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $subscriber->restore();
                $this->logActivity(['activity' => sprintf('Subscriber active.'), 'id' => $subscriber->id], true, true);
            } else {
                $subscriber->delete();
                $this->logActivity(['activity' => sprintf('Subscriber disable.'), 'id' => $subscriber->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    function uploadFile($file, $prefix, $fileName, $path, $model = null, $isImage = false)
    {
        if (!$file && $model) {
            return $model->{$fileName};
        }

        if ($file) {
            if ($model && !empty(trim($model->{$fileName}))) {
                deleteFileIfExist($path . $model->{$fileName}, true);
            }

            return $isImage ? upload_image($file, $path) : upload_file($file, $path, $prefix);
        }

        return null;
    }

    private function calculateFees($request, $key)
    {
        if (isset($request->package[$key])) {
            $courseFee = CourseFee::find($request->package[$key]);
            
            if ($courseFee) {
                return $courseFee->sale_fee;
            }
        }
    
        return null;
    }
    
}
