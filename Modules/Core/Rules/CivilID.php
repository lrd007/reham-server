<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class CivilID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $min = 12;
        $max = 12;
        $len = strlen($value);

        if ($len < 12) {
            return "Civil ID number is too short, minimum is $min characters ($max max)";
        } elseif ($len > $max) {
            return "Civil ID number is too long, maximum is $max characters ($min min).";
        }

        return is_valid_kw_civilid_checksum($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute should be correct Civil ID number.';
    }
}
