<?php

namespace Modules\Affiliate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AffiliateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignore = $this->getMethod() === 'PUT' ? $this->affiliate : '';
        
        return [
            'name_ar' => [
                'required',
                Rule::unique('affiliates')->ignore($ignore),
                'max:150'
            ],
            'name_en' => [
                'required',
                Rule::unique('affiliates')->ignore($ignore),
                'max:150'
            ],
            'start_date' => 'required',
            'end_date' => 'required',
            'payment_link' => 'required|url',
           // 'course_url' => 'required|url',
           // 'contract' => 'required_without:old_contract',
           // 'invoice' => 'required_without:old_invoice',
           // 'image' => 'required_without:old_image',
           // 'bonus_material' => 'required_without:old_bonus_material',
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
