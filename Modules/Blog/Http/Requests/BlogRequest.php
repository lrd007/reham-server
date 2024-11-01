<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->blog : '';
        
        return [
            'title_ar' => [
                'required',
                Rule::unique('blogs')->ignore($ignore),
                'max:150'
            ],
            'title_en' => [
                'required',
                Rule::unique('blogs')->ignore($ignore),
                'max:150'
            ],
            'tag' => 'required',
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
