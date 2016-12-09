<?php

namespace App\Forum\Core\Extensions\Validation;

use Illuminate\Support\Facades\Hash;

trait CustomValidatorRules
{
    /**
     * Check the users current password matches the inputted password value
     * @param  string $attribute
     * @param  string $value
     * @param  string $parameters
     * @return boolean
     */
    public function validateCheckPassword($attribute, $value, $parameters)
    {
        return Hash::check($value, auth()->user()->password);
    }
}