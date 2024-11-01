<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoursePackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->coursepackage : '';
        
        return [
            'name_ar' => [
                'required',
                Rule::unique('course_packages')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('course_packages')->ignore($ignore),
                'max:150'
            ],
            'days' => 'required|integer|min:1',
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
