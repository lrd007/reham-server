<?php

namespace Modules\Program\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Element;
use Modules\Program\Entities\Program;
use Modules\Program\Entities\Section;
use Modules\Program\Http\Requests\ProgramRequest;
use Yajra\DataTables\DataTables;

class ProgramController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('program.view');

        $data = [
            __('Id'),
            __('Name'),
            // __('Duration'),
            // __('Duration Type'),

            __('Created By'),
            __('Created At'),
            __('Status'),
            __('In HomePage'),
            __('Warranty Days'),
            __('Action')
        ];
        $table = [
            'id' => 'program_table',
            'source' => route('program.list'),
            'data' => $data
        ];

        return view('program::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('program.view');

        $canUpdate = auth()->user()->can('program.update');
        $canDelete = auth()->user()->can('program.delete');
        // $canShare = auth()->user()->can('program.share');
        $builder = Program::select(['id', 'name' . withLocalization(), 'created_by', 'created_at', 'deleted_at','in_home_page','warranty'])->withTrashed();

        return $dataTables::of($builder)
            ->removeColumn('thumb_image_url')
            ->editColumn('name' . withLocalization(), function ($item) {
                return '<a href="#" class="modal-button" data-url="' . route('program.hierarchy', $item->id) . '" data-toggle="modal">' . $item->{'name' . withLocalization()} . '</a>';
            })

            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("program.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_by', function ($item) {
                return isset($item->user) ? $item->user->name : "";
            })
            ->editColumn('created_at', function ($item) {
                return showDate($item->created_at);
            })
            ->addColumn('in_home_page',function ($item){
                return statusSwitchForHome(
                    $item->id,
                    route("program.change.in_home_page", $item->id),
                    $item->in_home_page
                );
            })
            ->editColumn('warranty',function ($item){
                return $item->warranty.'  Days';
            })
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("program.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("program.destroy", $item->id), $canDelete, true);
                $buttons .= shareUrl($item->id);

                return $buttons;
            }, 7)
            ->rawColumns(range(0, 7))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('program.create');

        $action = route('program.store');
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('program::program', compact('action', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ProgramRequest $request)
    {
        $this->authorize('program.create');

        try {
            $path = uploads_images('program');

            $program = new Program;
            $program->name_ar = $request->name_ar;
            $program->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $program->caption_ar = $request->caption_ar;
            $program->caption_en = empty($request->caption_en) ? $request->caption_ar : $request->caption_en;
            $program->description_ar = $request->description_ar;
            $program->description_en = empty($request->description_en) ? $request->description_ar : $request->description_en;
            $program->description_ar_2 = $request->description_ar_2;
            $program->description_en_2 = empty($request->description_en_2) ? $request->description_ar_2 : $request->description_en_2;
            $program->vimeo = $request->vimeo;
            /*$program->duration = $request->duration;
            $program->duration_type = $request->duration_type;*/
            $program->start_date = $request->type ? $request->start_date : NULL;
            $program->end_date = $request->type ? $request->end_date : NULL;
            $program->type = $request->type ? 1 : 0;
            $program->thumb_image = uploadFile($request, 'program_thumbnail_', 'thumb_image', 'thumbnail', $path);
            $program->deleted_at = now();
            $program->warranty = isset($request->warranty) ? $request->warranty : 13;
            $program->created_by = auth()->user()->id;
            $program->save();

            $program->courses()->sync($request->courses);

            $this->logActivity(['activity' => sprintf('Program created.'), 'id' => $program->id], true, true);
        } catch (Exception $e) {
            return $this->error($e);
        }

        return $this->success(['redirection' => route('program.index')]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('program::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('program.update');

        $action = route('program.update', $id);
        $program = Program::withTrashed()->findOrFail($id);
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('program::program', compact('action', 'program', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ProgramRequest $request, $id)
    {
        $this->authorize('program.update');

        try {

            $path = uploads_images('program');

            $program = Program::withTrashed()->findOrFail($id);
            $program->name_ar = $request->name_ar;
            $program->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $program->caption_ar = $request->caption_ar;
            $program->caption_en = empty($request->caption_en) ? $request->caption_ar : $request->caption_en;
            $program->description_ar = $request->description_ar;
            $program->description_en = empty($request->description_en) ? $request->description_ar : $request->description_en;
            $program->description_ar_2 = $request->description_ar_2;
            $program->description_en_2 = empty($request->description_en_2) ? $request->description_ar_2 : $request->description_en_2;
            $program->vimeo = $request->vimeo;
            /*$program->duration = $request->duration;
            $program->duration_type = $request->duration_type;*/
            $program->start_date = $request->type ? $request->start_date : NULL;
            $program->end_date = $request->type ? $request->end_date : NULL;
            $program->type = $request->type ? 1 : 0;
            $program->thumb_image = uploadFile($request, 'program_thumbnail_', 'thumb_image', 'thumbnail', $path, $program);
            $program->created_by = auth()->user()->id;
            $program->warranty = $request->warranty;
            $program->save();

            $program->courses()->sync($request->courses);

            $this->logActivity(['activity' => sprintf('Program updated.'), 'id' => $program->id], true, true);
        } catch (Exception $e) {
            return $this->error($e);
        }

        return $this->success(['redirection' => route('program.index')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('program.delete');

        try {
            $program = Program::withTrashed()->findOrFail($id);
            $program->forceDelete();

            $this->logActivity(['activity' => sprintf('Program deleted.'), 'id' => $program->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function courseByProgram(Request $request)
    {
        $programIds = explode(',', $request->program_ids);
        $courses = Course::whereHas('programs', function ($query) use ($programIds) {
            $query->whereIn('program_id', $programIds);
        })->orderBy('name' . withLocalization())->select('name' . withLocalization() . ' as name', 'id')->get()->toArray();
        return $this->success(['courses' => $courses]);
    }

    public function changeStatus($id)
    {
        $this->authorize('program.delete');

        try {
            $program = Program::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $program->restore();
                $this->logActivity(['activity' => sprintf('Program active.'), 'id' => $program->id], true, true);
            } else {
                $program->delete();
                $this->logActivity(['activity' => sprintf('Program disable.'), 'id' => $program->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    public function changeinHomePage($id)
    {
        $this->authorize('program.update');

        try{
            $program = Program::withTrashed()->findOrFail($id);
            if (isset(request()->in_home_page)) {
                $program['in_home_page'] = true;
                $program->save();
                $this->logActivity(['activity' => sprintf('Program active in Home Page.'), 'id' => $program->id], true, true);
            } else {
                $program['in_home_page'] = false;
                $program->save();
                $this->logActivity(['activity' => sprintf('Program disable in Home Page.'), 'id' => $program->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function programHierarchy($id)
    {
        try {

            $program = Program::withTrashed()->findOrFail($id);
            return view('program::hierarchy', compact('program'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Store program section and
     * element detail.
     */
    public function programSectionAndElement(Request $request)
    {
        $request->validate([
            'section_title_ar' => 'required',
            'section_title_en' => 'required',
            'program' => 'required',
            'title_ar.*' => 'required|max:150',
            'title_en.*' => 'required|max:150',
            'description_ar.*' => 'required',
            'description_en.*' => 'required',
            'image.*' => 'required'
        ], [
            'title_ar.*.required' => __('The title AR field is required.'),
            'title_en.*.required' => __('The title EN field is required.'),
            'description_ar.*.required' => __('The description AR field is required.'),
            'description_en.*.required' => __('The description EN field is required.'),
            'image.*.required' => __('The image field is required.'),
        ]);

        $section = $request->has('section_id') && $request->section_id ? Section::findOrFail($request->section_id) : new Section;
        $section->program_id = $request->program;
        $section->title_ar = $request->section_title_ar;
        $section->title_en = empty($request->section_title_en) ? $request->section_title_ar : $request->section_title_en;
        $section->save();

        $path = uploads_files('program_elements');
        $elementIds = isset($request->element_id) && is_array($request->element_id) ? $request->element_id : [];
        Element::where('section_id', $section->id)->whereNotIn('id', $elementIds)->delete();

        foreach ($request->title_ar as $key => $title_ar) {

            $element = isset($request->element_id[$key]) ? Element::findOrFail($request->element_id[$key]) : new Element;
            $element->section_id = $section->id;
            $element->title_ar = $title_ar;
            $element->title_en = empty($request->title_en[$key]) ? $title_ar : $request->title_en[$key];
            $element->description_ar = $request->description_ar[$key];
            $element->description_en = empty($request->description_en[$key]) ? $request->description_ar[$key] : $request->description_en[$key];
            $element->image = isset($request->image[$key]) ? $this->uploadFile($request->image[$key], 'program_element_', 'program_element', $path) : $element->image;
            $element->save();
        }

        return $this->success(['redirection' => route('program.section.index')]);
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

    public function programSectionIndex()
    {
        $this->authorize('program.view');

        $data = [
            __('Id'),
            __('TITLE'),
            __('Program'),
            __('Action')
        ];
        $table = [
            'id' => 'program_table',
            'source' => route('program.section.list'),
            'data' => $data
        ];

        return view('program::program-section-index', compact('table'));
    }

    public function programSectionList(DataTables $dataTables)
    {
        $this->authorize('program.view');

        $canUpdate = auth()->user()->can('program.update');
        $canDelete = auth()->user()->can('program.delete');
        $builder = Section::select(['id', 'title' . withLocalization(), 'program_id']);

        return $dataTables::of($builder)
            ->editColumn('program_id', function ($item) {
                return isset($item->program->{'name' . withLocalization()}) ? $item->program->{'name' . withLocalization()} : '';
            })
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("program.section.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("program.section.delete", $item->id), $canDelete, true);

                return $buttons;
            }, 4)
            ->rawColumns(range(0, 4))
            ->make(false);
    }

    public function programSectionCreate()
    {
        $programs = Program::all();
        return view('program::section', compact('programs'));
    }

    public function programSectionEdit($id)
    {
        $programs = Program::all();
        $section = Section::findOrFail($id);
        return view('program::section', compact('programs', 'section'));
    }

    public function programSectionDelete($id)
    {
        try {

            $section = Section::findOrFail($id);
            $section->elements()->delete();
            $section->delete();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
