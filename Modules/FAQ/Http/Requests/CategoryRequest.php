<?php

namespace Modules\FAQ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->faq_category : '';
        
        return [
            'name_ar' => [
                'required',
                Rule::unique('categories')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('categories')->ignore($ignore),
                'max:150'
            ]
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
