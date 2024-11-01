<?php

namespace Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->event : '';
        return [
            'title_ar' => [
                'required',
                Rule::unique('events')->ignore($ignore),
                'max:150'
            ],
            'title_en' => [
                'required',
                Rule::unique('events')->ignore($ignore),
                'max:150'
            ],
            'start_date' => 'required',
            'link' => 'url|nullable',
           // 'image' => 'required_without:old_image',
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
