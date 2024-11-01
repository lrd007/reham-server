<?php

namespace Modules\Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->coupon : '';
        
        return [
            'code' => [
                'required',
                Rule::unique('coupons')->ignore($ignore),
                'max:150'
            ],
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date|required_with:end_date',
            'end_date' => 'nullable|required_with:start_date|after_or_equal:start_date',
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
