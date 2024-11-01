<?php

namespace Modules\Quiz\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->quiz : '';
        
        return [
            'name_ar' => [
                'required',
                Rule::unique('quizzes')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('quizzes')->ignore($ignore),
                'max:150'
            ],
            'course' => 'required',
            'chapter' => 'required',
            'lesson' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
