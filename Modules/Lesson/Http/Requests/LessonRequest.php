<?php

namespace Modules\Lesson\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->lesson : '';
        $video = $ignore ? '' : 'required_if:type,=,video';
        
        return [
            'name_ar' => [
                'required',
             //   Rule::unique('lessons')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
            //    Rule::unique('lessons')->ignore($ignore),
                'max:150'
            ],
            'course' => 'required',
            'chapter' => 'required',
            'type' => 'required',
            'thumbnail' => 'required_without:old_thumbnail',
            'video' => $video,
            // 'embeded_code' => 'required_if:type,=,vimeo',
            'vimeo_url' => 'required_if:type,=,vimeo',
            'duration' => 'required_if:type,=,vimeo'
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
