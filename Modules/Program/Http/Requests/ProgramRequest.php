<?php

namespace Modules\Program\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->program : '';

        return [
            'name_ar' => [
                'required',
                Rule::unique('programs')->ignore($ignore),
                'max:190'
            ],
            'name_en' => [
                'required',
                Rule::unique('programs')->ignore($ignore),
                'max:190'
            ],
            'vimeo' => 'required',
            'thumbnail' => 'required_without:old_thumbnail',
            'start_date' => 'nullable|required_if:type,==,1|required_with:end_date',
            'end_date' => 'nullable|required_if:type,==,1|required_with:start_date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'start_date.required_if' => __('The start date field is required when program is special.'),
            'end_date.required_if' => __('The end date field is required when program is special.'),
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
