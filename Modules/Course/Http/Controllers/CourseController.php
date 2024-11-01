<?php

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Coupon\Entities\Coupon;
use Modules\Course\Entities\Course;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Program\Entities\Program;
use Modules\Tag\Entities\Tag;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Chapter\Entities\Chapter;
use Modules\Course\Entities\CourseBonusMaterial;
use Modules\Course\Entities\CourseFee;
use Modules\Course\Entities\CoursePackage;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\GetStarted;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('course.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Program'),
            __('Tag'),
            /*__('Duration'),
            __('Duration Type'),*/
            __('Created By'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'course_table',
            'source' => route('course.list'),
            'data' => $data
        ];

        return view('course::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('course.view');

        $canUpdate = auth()->user()->can('course.update');
        $canDelete = auth()->user()->can('course.delete');
        $builder = Course::select(['id', 'name' . withLocalization(), 'created_by', 'created_at', 'deleted_at'])->withTrashed();

        if (request()->has('program')) {
            $builder = $builder->whereHas('programs', function ($query) {
                $query->whereIn('program_id', request()->program);
            });
        }

        return $dataTables::of($builder)
            ->removeColumn('thumb_image_url')
            ->removeColumn('file_url')
            ->removeColumn('get_started_video_url')
            ->addColumn('program', function ($item) {
                $label = '';
                foreach ($item->programs as $program) {
                    $label .= '<label class="badge bg-soft-primary text-primary p-1">' . $program->{'name' . withLocalization()} . '</label> ';
                }

                return $label;
            }, 2)
            ->addColumn('tag', function ($item) {
                $label = '';
                foreach ($item->tags as $tag) {
                    $label .= '<label class="badge bg-soft-primary text-primary p-1">' . $tag->{'name' . withLocalization()} . '</label> ';
                }

                return $label;
            }, 3)
            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("course.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_by', function ($item) {
                return $item->user->name;
            })
            ->editColumn('created_at', function ($item) {
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("course.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("course.destroy", $item->id), $canDelete, true);

                return $buttons;
            })
            ->rawColumns(range(0, 10))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('course.store');
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $tags = Tag::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $coupons = Coupon::orderBy('code')->select('code', 'id', 'amount')->get();
        $bonusMaterials = BonusMaterial::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $coursePackages = CoursePackage::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('course::course', compact('action', 'programs', 'tags', 'coupons', 'bonusMaterials', 'coursePackages'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('course.create');

        try {
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $path = uploads_images('course');
            $course = new Course;
            $course->name_ar = $nameAr;
            $course->slug_ar = Str::slug($nameAr);
            $course->name_en = $nameEn;
            $course->slug_en = Str::slug($nameEn);
            $course->thumb_image = uploadFile($request, 'course_thumbnail_', 'thumb_image', 'thumbnail', $path);
            $course->file_type = $request->file_type;
            if ($request->file_type == 'image' || $request->file_type == "video") {
                $course->file = uploadFile($request, 'course_file_', 'thumb_image', 'file', $path);
            } else if ($request->file_type == "vimeo") {
                $course->vimeo_link = $request->vimeo_link;
            }

            if ($request->hasFile('audio')) {
                $audioFile = $request->file('audio');
                $audioName = 'course_audio_' . time() . '.' . $audioFile->getClientOriginalExtension();
                $audioPath = public_path('assets');  
                $audioFile->move($audioPath, $audioName);  
        
                $course->audio = 'assets/' . $audioName;
            }

            // $course->get_started_type = $request->get_started_type;
            // if ($request->get_started_type == "video") {
            //     $course->get_started_video = uploadFile($request, 'course_file_', 'get_started', 'get_started_video', $path);
            // } else if ($request->get_started_type == "vimeo") {
            //     $course->get_started_vimeo = $request->get_started_vimeo;
            // }

            $course->description_ar = $request->description_ar;
            $course->description_en = $request->description_en;

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $course->schedule = $request->schedule;
                //    $course->deleted_at = now();
            }

            $course->created_by = auth()->user()->id;
            /*$course->duration = $request->duration;
            $course->duration_type = $request->duration_type;*/
            $course->save();

            $course->tags()->sync($request->tag);
            $course->programs()->sync($request->program);
            $course->bonusMaterials()->sync($request->bonus_material);

            $this->logActivity(['activity' => sprintf('Course created.'), 'id' => $course->id], true, true);

            return $this->success(['redirection' => route('course.edit', $course->id)]);
        } catch (Exception $e) {
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
        return view('course::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = route('course.update', $id);
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $tags = Tag::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $coupons = Coupon::orderBy('code')->select('code', 'id', 'amount')->get();
        $course = Course::withTrashed()->findOrFail($id);
        $bonusMaterials = BonusMaterial::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $bonusMaterialIds = $course->bonusMaterials()->pluck('bonus_material_id')->toArray();
        $coursePackages = CoursePackage::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('course::course', compact('action', 'programs', 'tags', 'course', 'coupons', 'bonusMaterials', 'bonusMaterialIds', 'coursePackages'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CourseRequest $request, $id)
    {
        $this->authorize('course.update');

        try {
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $path = uploads_images('course');
            $course = Course::findOrFail($id);

            $course->name_ar = $nameAr;
            $course->slug_ar = Str::slug($nameAr);
            $course->name_en = $nameEn;
            $course->slug_en = Str::slug($nameEn);
            $course->thumb_image = uploadFile($request, 'course_thumbnail_', 'thumb_image', 'thumbnail', $path, $course);
            $course->file_type = $request->file_type;
            if ($request->file_type == 'image' || $request->file_type == "video") {
                $course->file = uploadFile($request, 'course_file_', 'thumb_image', 'file', $path, $course);
            } else if ($request->file_type == "vimeo") {
                $course->vimeo_link = $request->vimeo_link;
            }


            if ($request->hasFile('audio')) {
                if ($course->audio) {
                    $existingAudioPath = public_path($course->audio);
                    if (file_exists($existingAudioPath)) {
                        unlink($existingAudioPath);
                    }
                }
        
                $audioFile = $request->file('audio');
                $audioName = 'course_audio_' . time() . '.' . $audioFile->getClientOriginalExtension();
                $audioPath = public_path('assets');  
                $audioFile->move($audioPath, $audioName); 
        
                $course->audio = 'assets/' . $audioName;
            }
        
            // $course->get_started_type = $request->get_started_type;
            // if ($request->get_started_type == "video") {
            //     $course->get_started_video = uploadFile($request, 'course_file_', 'get_started', 'get_started_video', $path, $course);
            // } else if ($request->get_started_type == "vimeo") {
            //     $course->get_started_vimeo = $request->get_started_vimeo;
            // }

            $course->description_ar = $request->description_ar;
            $course->description_en = $request->description_en;

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $course->schedule = $request->schedule;
                //    $course->deleted_at = now();
            }

            $course->created_by = auth()->user()->id;
            /*$course->duration = $request->duration;
            $course->duration_type = $request->duration_type;*/
            $course->save();

            $course->tags()->sync($request->tag);
            $course->programs()->sync($request->program);
            $course->bonusMaterials()->sync($request->bonus_material);

            $this->logActivity(['activity' => sprintf('Course updated.'), 'id' => $course->id], true, true);

            return $this->success();
        } catch (Exception $e) {
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
        //
    }

    public function courseFee(Request $request)
    {
        $this->authorize('course.create');

        $request->validate([
            'course_id' => 'required',
            'fee.*' => 'required|numeric',
            'sale_fee.*' => 'required|numeric',
            'package.*' => 'required',
            'password' => 'required'
        ], [
            'course_id.required' => __('Please create course first.'),
            'fee.*.required' => __('Fee field is required.'),
            'sale_fee.*.required' => __('Sale fee field is required.'),
            'fee.*.required' => __('Fee field should be numeric.'),
            'sale_fee.*.required' => __('Sale fee field should be numeric.'),
            'package.*.required' => __('Package field is required.'),
        ]);

        if ($request->password != 'admin') {
            return $this->error(__("Password dosen't match."));
        }

        DB::beginTransaction();

        try {

            $courseFeeIds = $request->course_fee_id ?: [];
            CourseFee::where('course_id', $request->course_id)->whereNotIn('id', $courseFeeIds)->delete();

            foreach ($request->package as $key => $package) {

                if ($request->course_fee_id && isset($request->course_fee_id[$key])) {
                    $courseFee = CourseFee::findOrFail($request->course_fee_id[$key]);
                } else {
                    $courseFee = new CourseFee;
                }

                $courseFee->course_package_id = $package;
                $courseFee->sale_fee = $request->sale_fee[$key];
                $courseFee->fee = $request->fee[$key];
                $courseFee->course_id = $request->course_id;
                $courseFee->save();
            }

            $this->logActivity(['activity' => sprintf('Course fee updated.'), 'id' => $request->course_id], true, true);

            DB::commit();

            return $this->success();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    public function courseCoupon(Request $request)
    {
        $this->authorize('course.create');

        $request->validate([
            'course_id' => 'required',
            'coupon' => 'required',
        ], [
            'course_id.required' => __('Please create course first.'),
        ]);

        try {
            $course = Course::findOrFail($request->course_id);
            $course->coupon_code = $request->coupon;
            $course->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function courseBonus(Request $request)
    {
        $this->authorize('course.create');

        $request->validate([
            'course_id' => 'required',
            'bonus_material' => 'required',
        ], [
            'course_id.required' => __('Please create course first.'),
        ]);

        try {
            $path = uploads_files('course_bonus_material');
            $course = Course::findOrFail($request->course_id);

            $material = new CourseBonusMaterial;
            $material->course_id = $course->id;
            $material->file_path = uploadFile($request, 'course_bonus_material_', 'file_path', 'bonus_material', $path);
            $material->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function courseBonusDate(Request $request)
    {

        $this->authorize('course.create');

        $request->validate([
            'course_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date'
        ], [
            'course_id.required' => __('Please create course first.'),
        ]);

        try {
            $course = Course::findOrFail($request->course_id);
            $course->bonus_start_date = $request->start_date;
            $course->bonus_end_date = $request->end_date;
            $course->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function courseBonusDelete($id)
    {

        $this->authorize('course.delete');

        try {

            $path = uploads_files('course_bonus_material');
            $courseBonus = CourseBonusMaterial::findOrFail($id);
            deleteFileIfExist($path . $courseBonus->file_path, true);
            $courseBonus->delete();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function chapterByCourse(Request $request)
    {
        $courseIds = explode(',', $request->course_ids);
        $chapters = Chapter::whereIn('course_id', $courseIds)->orderBy('name' . withLocalization())->select('name' . withLocalization() . ' as name', 'id')->get()->toArray();
        return $this->success(['chapters' => $chapters]);
    }

    public function packageByCourse(Request $request)
    {
        $courseIds = explode(',', $request->course_ids);
        $packages = CourseFee::with(['coursePackage' => function ($query) {
            $query->orderBy('name' . withLocalization())->select('name' . withLocalization() . ' as name', 'id', 'days');
        }])->whereIn('course_id', $courseIds)->get()->toArray();
        return $this->success(['packages' => $packages]);
    }

    public function changeStatus($id)
    {
        $this->authorize('course.delete');

        try {
            $course = Course::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $course->restore();
                $this->logActivity(['activity' => sprintf('Course active.'), 'id' => $course->id], true, true);
            } else {
                $course->delete();
                $this->logActivity(['activity' => sprintf('Course disable.'), 'id' => $course->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getStarted(Request $request)
    {
        $this->authorize('course.create');

        $request->validate([
            'course_id' => 'required',
            'title_ar.*' => 'required',
            'title_en.*' => 'required',
            'description_ar.*' => 'required',
            'description_en.*' => 'required',
            'file.*' => 'required_if:type.*,==,video',
            'vimeo.*' => 'required_if:type.*,==,vimeo',
        ], [
            'course_id.required' => __('Please create course first.'),
            'title_ar.*.required' => __('The title AR field is required.'),
            'title_en.*.required' => __('The title EN field is required.'),
            'description_ar.*.required' => __('The description AR field is required.'),
            'description_en.*.required' => __('The description EN field is required.'),
            'file.*.required_if' => __('The file field is required.'),
            'vimeo.*.required_if' => __('The vimeo field is required.'),
        ]);

        try {

            GetStarted::where('course_id', $request->course_id)->delete();

            foreach ($request->title_ar as $key => $title_ar) {

                $path = uploads_files('get_started_material');

                $material = new GetStarted;
                $material->course_id = $request->course_id;
                $material->title_ar = $title_ar;
                $material->title_en = empty($request->title_en[$key]) ? $title_ar : $request->title_en[$key];
                $material->description_ar = $request->description_ar[$key];
                $material->description_en = empty($request->description_en[$key]) ? $request->description_ar[$key] : $request->description_en[$key];
                $material->type = $request->type[$key] == 'vimeo' ? 1 : 0;
                if ($request->type[$key] == 'video' && !empty($request->file[$key])) {
                    $material->file = isset($request->file[$key]) ? $this->uploadFile($request->file[$key], 'get_started_material_', 'get_started_material', $path) : NULL;
                } else {
                    $material->file = $request->vimeo[$key];
                }
                $material->save();
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function uploadFile($file, $prefix, $fileName, $path, $model = null, $isImage = false)
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

    public function filterForm()
    {
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('course::filter-form', compact('programs'));
    }
}
