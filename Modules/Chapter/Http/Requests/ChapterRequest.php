<?php

namespace Modules\Chapter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChapterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->chapter : '';
        
        return [
            'name_ar' => [
                'required',
             //   Rule::unique('chapters')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
              //  Rule::unique('chapters')->ignore($ignore),
                'max:150'
            ],
            'course' => 'required',
            'thumbnail' => 'required_without:old_thumbnail'
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
