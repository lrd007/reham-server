<?php

namespace Modules\Quiz\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use Modules\Quiz\Entities\Quiz;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Modules\Chapter\Entities\Chapter;
use Modules\Lesson\Entities\Lesson;
use Modules\Quiz\Entities\Question;
use Modules\Quiz\Exports\QuizExport;
use Exception;
use Excel;
use Modules\Quiz\Http\Requests\QuizRequest;
use PDF;

class QuizController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('quiz.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Chapter'),
            __('Lesson'),
            __('Schedule On'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'quiz_table',
            'source' => route('quiz.list'),
            'data' => $data
        ];

        return view('quiz::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('quiz.view');

        $canUpdate = auth()->user()->can('quiz.update');
        $canDelete = auth()->user()->can('quiz.delete');
        $builder = Quiz::select(['id','name' . withLocalization(), 'chapter_id', 'lesson_id', 'schedule', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            ->editColumn('chapter_id', function ($item){
                return ($item->chapter->{'name' . withLocalization()}) ?? '';
            })
            ->editColumn('lesson_id', function ($item){
                return ($item->lesson->{'name' . withLocalization()}) ?? '';
            })
            ->editColumn('schedule', function ($item){
                return showDateTime($item->schedule);
            })
            ->editColumn('deleted_at', function ($item){
                return statusSwitch($item->id, route("quiz.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete){

                $buttons = editButton(route("quiz.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("quiz.destroy", $item->id), $canDelete, true);

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
        $action = route('quiz.store');
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $chapters = [];
        $lessons = [];
        return view('quiz::quiz', compact('action', 'courses', 'chapters', 'lessons'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(QuizRequest $request)
    {
        $this->authorize('quiz.create');

        try{
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $quiz = new Quiz;
            $quiz->name_ar = $request->name_ar;
            $quiz->name_en = $nameEn;
            $quiz->slug = Str::slug($nameEn);
            $quiz->course_id = $request->course;
            $quiz->chapter_id = $request->chapter;
            $quiz->lesson_id = $request->lesson;

            if($request->has('post_or_schedule') && $request->post_or_schedule) {
                $quiz->schedule = $request->schedule;
                $quiz->deleted_at = now();
            }

            $quiz->save();

            $this->logActivity(['activity' => sprintf('Quiz created.'), 'id' => $quiz->id], true, true);

            return $this->success(['redirection'=> route('quiz.edit', $quiz->id)]);
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
        return view('quiz::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $quiz = Quiz::withTrashed()->findOrFail($id);
        $action = route('quiz.update', $id);
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $chapters = Chapter::where('course_id', $quiz->course_id)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $lessons = Lesson::where('chapter_id', $quiz->chapter_id)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();

        return view('quiz::quiz', compact('action', 'courses', 'quiz', 'chapters', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(QuizRequest $request, $id)
    {
        $this->authorize('quiz.update');

        try{
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $quiz = Quiz::findOrFail($id);
            $quiz->name_ar = $request->name_ar;
            $quiz->name_en = $nameEn;
            $quiz->slug = Str::slug($nameEn);
            $quiz->course_id = $request->course;
            $quiz->chapter_id = $request->chapter;
            $quiz->lesson_id = $request->lesson;

            if($request->has('post_or_schedule') && $request->post_or_schedule) {
                $quiz->schedule = $request->schedule;
                $quiz->deleted_at = now();
            }

            $quiz->save();

            $this->logActivity(['activity' => sprintf('Quiz updated.'), 'id' => $quiz->id], true, true);

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
        $this->authorize('quiz.delete');

        try{

            $quiz = Quiz::withTrashed()->findOrFail($id);

            $quiz->questions()->delete();

            $quiz->forceDelete();

            $this->logActivity(['activity' => sprintf('Quiz deleted.'), 'id' => $quiz->id], true, true);
            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function storeQuestion(Request $request)
    {
        $this->authorize('quiz.create');

        $request->validate([
            'quiz_id' => 'required',
            'question_ar.*' => 'required',
            'question_en.*' => 'required',
            'marks.*' => 'required|integer',
        ],[
            'quiz_id.required' => __('Please create quiz first.'),
            'question_ar.*.required' => __('Question AR field is required.'),
            'question_en.*.required' => __('Question EN field is required.'),
            'marks.*.required' => __('Marks field is required.'),
        ]);

        if(!$request->question_ar) {
            return $this->error(__('Please add question first.'));
        }

        try{

            Question::where('quiz_id', $request->quiz_id)->delete();

            foreach($request->question_ar as $questionNO => $questionAr) {

                $type = isset($request->question_type[$questionNO]) ? $request->question_type[$questionNO] : 'descriptive';
                $question = new Question;
                $question->question_ar = $questionAr;
                $question->question_en = $request->question_en[$questionNO];
                $question->marks = $request->marks[$questionNO];
                $question->type = $type;

                if($type == 'multiple') {
                    $question->possible_answer_ar = json_encode($request->answer_ar[$questionNO]);
                    $question->possible_answer_en = json_encode($request->answer_en[$questionNO]);
                    $question->currect_answer = $request->correct_answer[$questionNO];
                } else if($type == 'boolean') {
                    $question->currect_answer = $request->boolean_answer[$questionNO];
                } else {
                    $question->possible_answer_ar = $request->answer_ar[$questionNO][0];
                    $question->possible_answer_en = $request->answer_en[$questionNO][0];
                }

                $question->quiz_id = $request->quiz_id;
                $question->save();
            }

            $this->logActivity(['activity' => sprintf('Quiz question added.'), 'id' => $request->quiz_id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function exportExcel()
    {
        $this->authorize('quiz.export');

        return Excel::download(new QuizExport, 'Quiz.xlsx');
    }

    public function exportPDF()
    {
        $this->authorize('quiz.export');

        $quizzes = Quiz::withTrashed()->get();
        $pdf = PDF::loadView('quiz::export', ['quizzes' => $quizzes]);
        return $pdf->download('Quiz.pdf');
    }

    public function changeStatus($id)
    {
        $this->authorize('quiz.delete');

        try{
            $quiz = Quiz::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $quiz->restore();
                $this->logActivity(['activity' => sprintf('Quiz active.'), 'id' => $quiz->id], true, true);
            } else {
                $quiz->delete();
                $this->logActivity(['activity' => sprintf('Quiz disable.'), 'id' => $quiz->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
