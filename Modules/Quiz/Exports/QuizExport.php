<?php

namespace Modules\Quiz\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Quiz\Entities\Quiz;

class QuizExport implements FromView
{
    public function view(): View
    {
        return view('quiz::export', [
            'quizzes' => Quiz::withTrashed()->get()
        ]);
    }
}