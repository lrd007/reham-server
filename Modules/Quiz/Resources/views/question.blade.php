<div class="row" id="questionBox" style="display: none;">
    <div class="col-md-4">
        <div class="mb-3">
            <label >{{ __('Question') }} AR<span class="text-danger">*</span></label>
            <input type="text" name="question_ar[]" class="form-control" placeholder="{{ __('Question') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label >{{ __('Question') }} EN<span class="text-danger">*</span></label>
            <input type="text" name="question_en[]" class="form-control" placeholder="{{ __('Question') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label >{{ __('Marks') }}<span class="text-danger">*</span></label>
            <input type="text" name="marks[]" class="form-control" placeholder="{{ __('Marks') }}">
        </div>
    </div>
    <div class="col-md-1 text-right">
        <button type="button" class="btn btn-danger btn-sm waves-effect waves-light remove-row mt-1">{{ __('Remove') }} </button>
    </div>
</div>
<div id="multipleAnswerBox" style="display: none;">
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_ar[]" class="form-control" placeholder="{{ __('Answer') }} AR A">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_en[]" class="form-control" placeholder="{{ __('Answer') }} EN A">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <div class="radio radio-success form-check-inline mt-1">
                <input class="" type="radio" value="a" name="correct_answer[]" checked>
                <label>{{ __('Currect Answer') }} </label>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_ar[]" class="form-control" placeholder="{{ __('Answer') }} AR B">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_en[]" class="form-control" placeholder="{{ __('Answer') }} EN B">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <div class="radio radio-success form-check-inline mt-1">
                <input class="" type="radio" value="b" name="correct_answer[]">
                <label>{{ __('Currect Answer') }} </label>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_ar[]" class="form-control" placeholder="{{ __('Answer') }} AR C">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_en[]" class="form-control" placeholder="{{ __('Answer') }} EN C">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <div class="radio radio-success form-check-inline mt-1">
                <input class="" type="radio" value="c" name="correct_answer[]">
                <label>{{ __('Currect Answer') }} </label>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_ar[]" class="form-control" placeholder="{{ __('Answer') }} AR D">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <input type="text" name="answer_en[]" class="form-control" placeholder="{{ __('Answer') }} EN D">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <div class="radio radio-success form-check-inline mt-1">
                <input class="" type="radio" value="d" name="correct_answer[]">
                <label>{{ __('Currect Answer') }} </label>
            </div>
        </div>
    </div>
</div>
<div class="row" id="booleanAnswerBox" style="display: none;">
    <div class="col-sm-12">
        <div class="radio radio-success form-check-inline ml-1">
            <input class="post-or-schedule" type="radio" value="true" name="boolean_answer[]" checked>
            <label> {{ __('True') }} </label>
        </div>
        <div class="radio radio-success form-check-inline">
            <input class="post-or-schedule" type="radio" value="false" name="boolean_answer[]">
            <label>{{ __('False') }} </label>
        </div>
    </div>
</div>
<div class="row" id="descriptiveAnswerBox" style="display: none;">
    <div class="col-sm-6">
        <textarea name="answer_ar[]" class="form-control" placeholder="{{ __('Answer') }} AR"></textarea>
    </div>
    <div class="col-sm-6">
        <textarea name="answer_en[]" class="form-control" placeholder="{{ __('Answer') }} EN"></textarea>
    </div>
</div>

<form id="courseInfoForm" action="{{ route('quiz.store.question') }}" method="post">
    {{ csrf_field() }}    
    <div id="questionAnswerBox" data-plugin="dragula">
        @if(isset($quiz))
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
            @foreach($quiz->questions as $key => $question)
                <div class="row border-primary p-2 ml-1 mr-1 mb-2" style="border: 1px solid #ea8bb8" >
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label >{{ __('Question') }} AR<span class="text-danger">*</span></label>
                            <input type="text" name="question_ar[{{ $key }}]" class="form-control" placeholder="{{ __('Question') }}" value="{{ $question->question_ar }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label >{{ __('Question') }} EN<span class="text-danger">*</span></label>
                            <input type="text" name="question_en[{{ $key }}]" class="form-control" placeholder="{{ __('Question') }}" value="{{ $question->question_en }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label >{{ __('Marks') }}<span class="text-danger">*</span></label>
                            <input type="text" name="marks[{{ $key }}]" class="form-control" placeholder="{{ __('Marks') }}" value="{{ $question->marks }}">
                        </div>
                    </div>
                    <div class="col-md-1 text-right">
                        <button type="button" class="btn btn-danger btn-sm waves-effect waves-light remove-row mt-1">{{ __('Remove') }} </button>
                    </div>
                    @if($question->type == 'boolean')
                        <input type="hidden" name="question_type[{{ $key }}]" value="boolean">
                        <div class="col-sm-12">
                            <div class="radio radio-success form-check-inline ml-1">
                                <input type="radio" value="true" name="boolean_answer[{{ $key }}]" @if($question->currect_answer == 'true') {{ 'checked' }} @endif>
                                <label> {{ __('True') }} </label>
                            </div>
                            <div class="radio radio-success form-check-inline">
                                <input type="radio" value="false" name="boolean_answer[{{ $key }}]" @if($question->currect_answer == 'false') {{ 'checked' }} @endif >
                                <label>{{ __('False') }} </label>
                            </div>
                        </div>
                    @elseif($question->type == 'descriptive')
                        <input type="hidden" name="question_type[{{ $key }}]" value="descriptive">
                        <div class="col-sm-6">
                            <textarea name="answer_ar[{{ $key }}][]" class="form-control" placeholder="{{ __('Answer') }} AR">{{ $question->possible_answer_ar }}</textarea>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="answer_en[{{ $key }}][]" class="form-control" placeholder="{{ __('Answer') }} EN">{{ $question->possible_answer_en }}</textarea>
                        </div>
                    @else
                        <input type="hidden" name="question_type[{{ $key }}]" value="multiple">
                        @php
                            $answerAr = json_decode($question->possible_answer_ar);
                            $answerEn = json_decode($question->possible_answer_en);
                        @endphp

                        @foreach($answerAr as $answerKey => $answer)
                            @php
                                $optionValue = strtolower(config('constant.answer_option')[$answerKey]);
                            @endphp
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="answer_ar[{{ $key }}][]" class="form-control" placeholder="{{ __('Answer') }} AR {{ config('constant.answer_option')[$answerKey] }}" value="{{ $answer }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="answer_en[{{ $key }}][]" class="form-control" placeholder="{{ __('Answer') }} EN {{ config('constant.answer_option')[$answerKey] }}" value="{{ $answerEn[$answerKey] }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="radio radio-success form-check-inline mt-1">
                                        <input class="" type="radio" value="{{ $optionValue }}" name="correct_answer[{{ $key }}]" @if($optionValue == $question->currect_answer) {{ 'checked' }} @endif>
                                        <label>{{ __('Currect Answer') }} </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="text-right">
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="addQuestion">{{ __('Add Question') }}</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item add-question" href="#" data-type="multiple">{{ __('Multi Option') }}</a>
                        <a class="dropdown-item add-question" href="#" data-type="boolean">{{ __('True / False') }}</a>
                        <a class="dropdown-item add-question" href="#" data-type="descriptive">{{ __('Descriptive') }}</a>
                    </div>
                </div>
                <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
            </div>
        </div>
    </div>
    
</form>