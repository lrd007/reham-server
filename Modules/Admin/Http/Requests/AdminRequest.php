<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->admin_user : '';
        $isPasswordRequired = $ignore ? '' : 'required';

        return [
            'name' => 'required|max:190',            
            'email'  => [
                'required',
                'email',
                Rule::unique('users')->ignore($ignore)
            ],
            'vaccination_certificate' => 'mimes:jpg,jpeg,bmp,png,gif,svg,pdf',
            'password' => $isPasswordRequired . '|max:190',
            'role' => 'required'
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
