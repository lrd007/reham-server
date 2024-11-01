<?php

namespace Modules\Tag\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->tag : '';
        
        return [
            'name_ar' => [
                'required',
                Rule::unique('tags')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('tags')->ignore($ignore),
                'max:150'
            ],
            'progress' => 'nullable|integer|between:0,100'
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
