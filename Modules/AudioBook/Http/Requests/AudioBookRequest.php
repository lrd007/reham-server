<?php

namespace Modules\AudioBook\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AudioBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->audiobook : '';
        
        return [
            'name_ar' => [
                'required',
                Rule::unique('audio_books')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('audio_books')->ignore($ignore),
                'max:150'
            ],
            'author_ar' => 'required|max:150',
            'author_en' => 'required|max:150',
            'chapter' => 'required',
            'file' => 'required_without:old_file'
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
