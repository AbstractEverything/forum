<?php

namespace App\Forum\Core\Extensions\Validation;

use Illuminate\Validation\Validator;
use App\Forum\Core\Extensions\Validation\CustomValidatorRules;

class CustomValidator extends Validator
{
    use CustomValidatorRules;
}