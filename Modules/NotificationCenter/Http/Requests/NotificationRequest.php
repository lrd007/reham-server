<?php

namespace Modules\NotificationCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->notificationcenter : '';

        return [
            'send_to' => 'required',
            'medium' => 'required',
            'title' => 'required',
            'message' => 'required',
            'schedule' => 'required_if:is_schedule,==,1',
            'subscriber' => 'required_if:send_to,==,0',
            'program' => 'required_if:send_to,==,1'
        ];
    }

    public function messages()
    {
        return [
            'schedule.required_if' => __('The schedule date time is required.'),
            'subscriber.required_if' => __('Please select subscriber.'),
            'program.required_if' => __('The program field is required.'),
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
