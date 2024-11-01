<?php

namespace Modules\Lesson\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\Lesson;
use Modules\Chapter\Entities\Chapter;
use Modules\Program\Entities\Program;
use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Modules\Lesson\Http\Requests\LessonRequest;
use Modules\Lesson\Entities\LessonBonusMaterial;
use Modules\BonusMaterial\Entities\BonusMaterial;

class LessonController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('lesson.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Course'),
            __('Chapter'),
            __('Created By'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'lesson_table',
            'source' => route('lesson.list'),
            'data' => $data
        ];

        return view('lesson::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('lesson.view');

        $canUpdate = auth()->user()->can('lesson.update');
        $canDelete = auth()->user()->can('lesson.delete');
        $builder = Lesson::select(['id', 'name' . withLocalization(), 'course_id', 'chapter_id', 'created_by', 'created_at', 'deleted_at'])->withTrashed();

        if (request()->has('chapter')) {
            $builder = $builder->whereIn('chapter_id', request()->chapter);
        } else if (request()->has('course')) {
            $builder = $builder->whereIn('course_id', request()->course);
        } else if (request()->has('program')) {
            $builder = $builder->whereHas('course', function ($query) {
                $query->whereHas('programs', function ($query) {
                    $query->whereIn('program_id', request()->program);
                });
            });
        }

        return $dataTables::of($builder)
            ->removeColumn('is_completed')
            ->removeColumn('thumb_image_url')
            ->removeColumn('video_url')
            ->removeColumn('document_url')
            ->removeColumn('audio_url')
            ->editColumn('course_id', function ($item) {
                return $item->course ? '<label class="badge bg-soft-primary text-primary p-1">' . $item->course->{'name' . withLocalization()} . '</label> ' : '';
            })
            ->editColumn('chapter_id', function ($item) {
                return $item->chapter ? '<label class="badge bg-soft-primary text-primary p-1">' . $item->chapter->{'name' . withLocalization()} . '</label> ' : '';
            })
            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("lesson.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_by', function ($item) {
                return @$item->user->name;
            })
            ->editColumn('created_at', function ($item) {
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("lesson.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("lesson.destroy", $item->id), $canDelete, true);

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
        $this->authorize('lesson.create');

        $action = route('lesson.store');

        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $chapters = [];
        $bonusMaterials = BonusMaterial::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('lesson::lesson', compact('action', 'chapters', 'courses', 'bonusMaterials'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LessonRequest $request)
    {
        $this->authorize('lesson.create');

        try {
            $path = uploads_images('lesson');
            $filePath = uploads_files('lesson');
            $duration = $request->duration;
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;

            $lesson = new Lesson;
            $lesson->name_ar = $nameAr;
            $lesson->name_en = $nameEn;
            $lesson->slug = Str::slug($nameEn);
            $lesson->thumb_image = uploadFile($request, 'lesson_thumbnail_', 'thumb_image', 'thumbnail', $path);
            $lesson->description_ar = $request->description_ar;
            $lesson->description_en = $request->description_en;
            $lesson->related_link = $request->related_link;
            $lesson->course_id = $request->course;
            $lesson->chapter_id = $request->chapter;
            $lesson->type = $request->type;

            if ($request->type == 'video') {

                if ($request->video) {
                    $getID3 = new \getID3;
                    $file = $getID3->analyze($request->video);
                    $duration = gmdate('H:i:s', $file['playtime_seconds']);
                    $lesson->video = uploadFile($request, 'lesson_video_', 'video', 'video', $filePath);
                }

                if ($request->audio) {
                    $lesson->audio = uploadFile($request, 'lesson_audio_', 'audio', 'audio', $filePath);
                }
            } else {

                $lesson->vimeo_embeded_code = $request->embeded_code;
                $lesson->vimeo_url = $request->vimeo_url;
            }


            if ($request->document) {
                $lesson->document = uploadFile($request, 'lesson_document_', 'document', 'document', $filePath);
            }

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $lesson->schedule = $request->schedule;
                //  $lesson->deleted_at = now();
            }

            $lesson->duration = $duration;
            $lesson->is_comment_allowed = $request->is_comment_allowed ? 1 : 0;
            $lesson->created_by = auth()->user()->id;
            /*$lesson->duration_no = $request->duration_no;
            $lesson->duration_type = $request->duration_type;*/
            $lesson->save();

            $lesson->bonusMaterials()->sync($request->bonus_material);

            $this->logActivity(['activity' => sprintf('Lesson created.'), 'id' => $lesson->id], true, true);

            return $this->success(['redirection' => route('lesson.edit', $lesson->id)]);
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
        return view('lesson::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('lesson.update');

        $action = route('lesson.update', $id);

        $lesson = Lesson::findOrFail($id);
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $chapters = Chapter::where('course_id', $lesson->course_id)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $bonusMaterials = BonusMaterial::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $bonusMaterialIds = $lesson->bonusMaterials()->pluck('bonus_material_id')->toArray();
        return view('lesson::lesson', compact('action', 'chapters', 'courses', 'lesson', 'bonusMaterials', 'bonusMaterialIds'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(LessonRequest $request, $id)
    {
        $this->authorize('lesson.update');

        try {
            $path = uploads_images('lesson');
            $filePath = uploads_files('lesson');
            $duration = $request->duration;
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;

            $lesson = Lesson::findOrFail($id);
            $lesson->name_ar = $nameAr;
            $lesson->name_en = $nameEn;
            $lesson->slug = Str::slug($nameEn);
            $lesson->thumb_image = uploadFile($request, 'lesson_thumbnail_', 'thumb_image', 'thumbnail', $path, $lesson);
            $lesson->description_ar = $request->description_ar;
            $lesson->description_en = $request->description_en;
            $lesson->related_link = $request->related_link;
            $lesson->course_id = $request->course;
            $lesson->chapter_id = $request->chapter;
            $lesson->type = $request->type;

            if ($request->type == 'video') {

                if ($request->video) {
                    $getID3 = new \getID3;
                    $file = $getID3->analyze($request->video);
                    $duration = gmdate('H:i:s', $file['playtime_seconds']);
                    $lesson->video = uploadFile($request, 'lesson_video_', 'video', 'video', $filePath, $lesson);
                }

                if ($request->audio) {
                    $lesson->audio = uploadFile($request, 'lesson_audio_', 'audio', 'audio', $filePath, $lesson);
                }
            } else {

                $lesson->vimeo_embeded_code = $request->embeded_code;
                $lesson->vimeo_url = $request->vimeo_url;
            }

            if ($request->document) {
                $lesson->document = uploadFile($request, 'lesson_document_', 'document', 'document', $filePath, $lesson);
            }

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $lesson->schedule = $request->schedule;
                //  $lesson->deleted_at = now();
            }

            $lesson->duration = $duration;
            $lesson->is_comment_allowed = $request->is_comment_allowed ? 1 : 0;
            /*$lesson->duration_no = $request->duration_no;
            $lesson->duration_type = $request->duration_type;*/
            $lesson->save();

            $lesson->bonusMaterials()->sync($request->bonus_material);

            $this->logActivity(['activity' => sprintf('Lesson updated.'), 'id' => $lesson->id], true, true);

            return $this->success(['redirection' => route('lesson.edit', $lesson->id)]);
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
        $this->authorize('lesson.delete');

        try {
            $path = uploads_images('lesson');
            $filePath = uploads_files('lesson');
            $lesson = Lesson::findOrFail($id);

            $lesson->thumb_image ? deleteFileIfExist($path . $lesson->thumb_image, true) : '';
            $lesson->video ? deleteFileIfExist($filePath . $lesson->video, true) : '';
            $lesson->audio ? deleteFileIfExist($filePath . $lesson->audio, true) : '';
            $lesson->document ? deleteFileIfExist($filePath . $lesson->document, true) : '';

            $lesson->delete();

            $this->logActivity(['activity' => sprintf('Lesson deleted.'), 'id' => $lesson->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function lessonBonus(Request $request)
    {
        $this->authorize('lesson.create');

        $request->validate([
            'lesson_id' => 'required',
            'bonus_material' => 'required',
        ], [
            'lesson_id.required' => __('Please create lesson first.'),
        ]);

        try {
            $path = uploads_files('lesson_bonus_material');
            $lesson = Lesson::findOrFail($request->lesson_id);

            $material = new LessonBonusMaterial;
            $material->lesson_id = $lesson->id;
            $material->file_path = uploadFile($request, 'lesson_bonus_material_', 'file_path', 'bonus_material', $path);
            $material->save();

            $this->logActivity(['activity' => sprintf('Lesson bonus material added.'), 'id' => $lesson->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function lessonBonusDate(Request $request)
    {

        $this->authorize('lesson.create');

        $request->validate([
            'lesson_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date'
        ], [
            'lesson_id.required' => __('Please create lesson first.'),
        ]);

        try {
            $lesson = Lesson::findOrFail($request->lesson_id);
            $lesson->bonus_start_date = $request->start_date;
            $lesson->bonus_end_date = $request->end_date;
            $lesson->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function lessonBonusDelete($id)
    {

        $this->authorize('lesson.delete');

        try {

            $path = uploads_files('lesson_bonus_material');
            $lessonBonus = LessonBonusMaterial::findOrFail($id);
            deleteFileIfExist($path . $lessonBonus->file_path, true);
            $lessonBonus->delete();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('lesson.delete');

        try {
            $lesson = Lesson::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $lesson->restore();
                $this->logActivity(['activity' => sprintf('Lesson active.'), 'id' => $lesson->id], true, true);
            } else {
                $lesson->delete();
                $this->logActivity(['activity' => sprintf('Lesson disable.'), 'id' => $lesson->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function filterForm()
    {
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('lesson::filter-form', compact('programs'));
    }
}
