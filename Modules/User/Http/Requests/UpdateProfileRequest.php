<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'user::attributes.users';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'nullable|confirmed|min:6',
        ];
    }

    /**
     * Hash the user password against the bcrypt algorithm.
     *
     * @return $this|null
     */
    public function bcryptPassword()
    {
        if ($this->filled('password')) {
            return $this->merge(['password' => bcrypt($this->password)]);
        }

        unset($this['password']);
    }
}
