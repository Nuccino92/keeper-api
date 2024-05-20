<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\SportsEnum;
use ReflectionClass;

class ValidSport implements ValidationRule
/**
 * Validate the given value.
 *
 * @param  string  $attribute
 * @param  mixed  $value
 * @param  callable  $fail
 * @return void
 */
{
    public function validate($attribute, $value, $fail): void
    {
        $sports = (new ReflectionClass(SportsEnum::class))->getConstants();

        if (!in_array($value, $sports)) {
            $fail("The $attribute must be a valid sport.");
        }
    }
}
