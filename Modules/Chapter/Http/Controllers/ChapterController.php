<?php

namespace Modules\Chapter\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Chapter\Entities\Chapter;
use Modules\Course\Entities\Course;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Chapter\Entities\ChapterBonusMaterial;
use Modules\Chapter\Http\Requests\ChapterRequest;
use Modules\Lesson\Entities\Lesson;
use Modules\Program\Entities\Program;

class ChapterController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('chapter.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Course'),
            __('Program'),
            __('Created By'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'chapter_table',
            'source' => route('chapter.list'),
            'data' => $data
        ];

        return view('chapter::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('chapter.view');

        $canUpdate = auth()->user()->can('chapter.update');
        $canDelete = auth()->user()->can('chapter.delete');
        $builder = Chapter::select(['id', 'name' . withLocalization(), 'course_id', 'created_by', 'created_at', 'deleted_at'])->withTrashed();

        if (request()->has('course')) {
            $builder = $builder->whereHas('course', function ($query) {
                $query->whereIn('course_id', request()->course);
            });
        } else if (request()->has('program')) {
            $builder = $builder->whereHas('course', function ($query) {
                $query->whereHas('programs', function ($query) {
                    $query->whereIn('program_id', request()->program);
                });
            });
        }

        return $dataTables::of($builder)
            ->removeColumn('thumb_image_url')
            ->removeColumn('completion_percentage')
            ->editColumn('course_id', function ($item) {
                return $item->course ? '<label class="badge bg-soft-primary text-primary p-1">' . $item->course->{'name' . withLocalization()} . '</label>' : '';
            })
            ->addColumn('program', function ($item) {
                $label = '';
                if ($item->course) {
                    foreach ($item->course->programs as $program) {
                        $label .= '<label class="badge bg-soft-primary text-primary p-1">' . $program->{'name' . withLocalization()} . '</label> ';
                    }
                }

                return $label;
            }, 3)
            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("chapter.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_by', function ($item) {
                return $item->user->name;
            })
            ->editColumn('created_at', function ($item) {
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("chapter.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("chapter.destroy", $item->id), $canDelete, true);

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
        $this->authorize('chapter.create');

        $action = route('chapter.store');
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $bonusMaterials = BonusMaterial::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('chapter::chapter', compact('action', 'courses', 'bonusMaterials'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ChapterRequest $request)
    {
        $this->authorize('chapter.create');

        try {
            $path = uploads_images('chapter');
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $chapter = new Chapter;
            $chapter->name_ar = $request->name_ar;
            $chapter->name_en = $nameEn;
            $chapter->slug = Str::slug($nameEn);
            $chapter->thumb_image = $this->uploadFile($request, 'chapter', 'thumb_image', 'thumbnail', $path);
            $chapter->description_ar = $request->description_ar;
            $chapter->description_en = $request->description_en;
            $chapter->course_id = $request->course;
           /* $chapter->duration = $request->duration;*/

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $chapter->schedule = $request->schedule;
                //   $chapter->deleted_at = now();
            }

            $chapter->created_by = auth()->user()->id;
            /*$chapter->duration_no = $request->duration_no;
            $chapter->duration_type = $request->duration_type;*/
            $chapter->save();

            $chapter->bonusMaterials()->sync($request->bonus_material);

            $this->logActivity(['activity' => sprintf('Chapter created.'), 'id' => $chapter->id], true, true);

            return $this->success(['redirection' => route('chapter.edit', $chapter->id)]);
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
        return view('chapter::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('chapter.update');

        $chapter = Chapter::withTrashed()->findOrFail($id);
        $action = route('chapter.update', $id);
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $bonusMaterials = BonusMaterial::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $bonusMaterialIds = $chapter->bonusMaterials()->pluck('bonus_material_id')->toArray();
        return view('chapter::chapter', compact('action', 'courses', 'chapter', 'bonusMaterials', 'bonusMaterialIds'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ChapterRequest $request, $id)
    {
        $this->authorize('chapter.update');

        try {
            $path = uploads_images('chapter');
            $chapter = Chapter::findOrFail($id);
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;

            $chapter->name_ar = $request->name_ar;
            $chapter->name_en = $nameEn;
            $chapter->slug = Str::slug($nameEn);
            $chapter->thumb_image = $this->uploadFile($request, 'chapter', 'thumb_image', 'thumbnail', $path, $chapter);
            $chapter->description_ar = $request->description_ar;
            $chapter->description_en = $request->description_en;
            $chapter->course_id = $request->course;
           /* $chapter->duration = $request->duration;*/
            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $chapter->schedule = $request->schedule;
                //  $chapter->deleted_at = now();
            }

            $chapter->created_by = auth()->user()->id;
            /*$chapter->duration_no = $request->duration_no;
            $chapter->duration_type = $request->duration_type;*/
            $chapter->save();

            $chapter->bonusMaterials()->sync($request->bonus_material);

            $this->logActivity(['activity' => sprintf('Chapter updated.'), 'id' => $chapter->id], true, true);

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
        $this->authorize('chapter.delete');

        try {
            $program = Chapter::withTrashed()->findOrFail($id);
            $program->forceDelete();

            $this->logActivity(['activity' => sprintf('Chapter deleted.'), 'id' => $program->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function chapterBonus(Request $request)
    {
        $this->authorize('chapter.create');

        $request->validate([
            'chapter_id' => 'required',
            'bonus_material' => 'required',
        ], [
            'chapter_id.required' => __('Please create chapter first.'),
        ]);

        try {
            $path = uploads_files('chapter_bonus_material');
            $chapter = Chapter::findOrFail($request->chapter_id);

            $material = new ChapterBonusMaterial;
            $material->chapter_id = $chapter->id;
            $material->file_path = $this->uploadFile($request, 'chapter_bonus_material_', 'file_path', 'bonus_material', $path);
            $material->save();

            $this->logActivity(['activity' => sprintf('Chapter bonus material added.'), 'id' => $chapter->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function chapterBonusDate(Request $request)
    {

        $this->authorize('chapter.create');

        $request->validate([
            'chapter_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date'
        ], [
            'chapter_id.required' => __('Please create chapter first.'),
        ]);

        try {
            $chapter = Chapter::findOrFail($request->chapter_id);
            $chapter->bonus_start_date = $request->start_date;
            $chapter->bonus_end_date = $request->end_date;
            $chapter->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function chapterBonusDelete($id)
    {

        $this->authorize('chapter.delete');

        try {

            $path = uploads_files('chapter_bonus_material');
            $chapterBonus = ChapterBonusMaterial::findOrFail($id);
            deleteFileIfExist($path . $chapterBonus->file_path, true);
            $chapterBonus->delete();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function uploadFile($request, $prefix, $fileName, $file, $path, $model = null, $isImage = false)
    {
        if (!$request->hasFile($file) && $model) {
            return $model->{$fileName};
        }

        if ($model && !empty(trim($model->{$fileName}))) {
            deleteFileIfExist($path . $model->{$fileName}, true);
        }

        $file = $request->{$file};
        return $isImage ? upload_image($file, $path) : upload_file($file, $path, $prefix);
    }

    public function lessonByChapter(Request $request)
    {
        $chapterIds = explode(',', $request->chapter_ids);
        $lessons = Lesson::whereIn('chapter_id', $chapterIds)->orderBy('name' . withLocalization())->select('name' . withLocalization() . ' as name', 'id')->get()->toArray();
        return $this->success(['lessons' => $lessons]);
    }

    public function changeStatus($id)
    {
        $this->authorize('chapter.delete');

        try {
            $chapter = Chapter::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $chapter->restore();
                $this->logActivity(['activity' => sprintf('Chapter active.'), 'id' => $chapter->id], true, true);
            } else {
                $chapter->delete();
                $this->logActivity(['activity' => sprintf('Chapter disable.'), 'id' => $chapter->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function filterForm()
    {
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('chapter::filter-form', compact('programs'));
    }
}
