<?php

namespace Modules\Subscriber\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriberRequest extends FormRequest
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
            'email' => [
                'required',
                Rule::unique('users')->ignore($ignore),
                'max:150'
            ],
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'mobile_no' => 'required|digits_between:8,12',
            // 'program.*' => 'required',
            // 'course.*' => 'required',
            // 'package.*' => 'required',
            // 'start_date.*' => 'required',
            // 'end_date.*' => 'required|after_or_equal:start_date.*',
        ];
    }

    public function messages()
    {
        return [
            'program.*.required' => __('The program field is required.'),
            'course.*.required' => __('The course field is required.'),
            'package.*.required' => __('The package field is required.'),
            'start_date.*.required' => __('The start date field is required.'),
            'end_date.*.required' => __('The end date field is required.'),
            'end_date.*.after_or_equal' => __('The end date must be a date after or equal to start date.'),
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
