<?php

namespace Modules\BonusMaterial\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BonusMaterialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? request()->user_id : '';
        
        return [
            'name_ar' => 'required|max:150',
            'name_en' => 'required|max:150',
            'description_ar.*' => 'required',
            'description_en.*' => 'required',
            'file.*' => 'required_if:type.*,==,video',
            'vimeo.*' => 'required_if:type.*,==,vimeo',
        ];
    }

    public function messages()
    {
        return [
            'description_ar.*.required' => __('The description AR field is required.'),
            'description_en.*.required' => __('The description EN field is required.'),
            'file.*.required_if' => __('The file field is required.'),
            'vimeo.*.required_if' => __('The vimeo field is required.'),
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
