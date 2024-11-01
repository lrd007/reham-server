<?php

namespace Modules\FAQ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->faq : '';
        
        return [
            'question_ar' => [
                'required',
                Rule::unique('faqs')->ignore($ignore),
                'max:150'
            ],
            'question_en' => [
                'required',
                Rule::unique('faqs')->ignore($ignore),
                'max:150'
            ],
            'answer_ar' => 'required',
            'answer_en' => 'required',
            'legal_category' => 'required_if:type,==,1',
            'general_category' => 'required_if:type,==,0',
        ];
    }

    public function messages()
    {
        return [
            'legal_category.required_if' => __('The category field is required.'),
            'general_category.required_if' => __('The category field is required.'),
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
