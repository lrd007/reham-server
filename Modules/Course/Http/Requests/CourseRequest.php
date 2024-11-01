<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->course : '';

        return [
            'name_ar' => [
                'required',
                Rule::unique('courses')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('courses')->ignore($ignore),
                'max:150'
            ],
            'tag' => 'required',
            'thumbnail' => 'required_without:old_thumbnail',
            'program' => 'required',
            'file_type' => 'required',
            'audio' => 'nullable|mimes:mp3,wav,aac', 

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
