<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class HalfWidth implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (mb_strwidth($value) > mb_strlen($value))
            $fail('validation.alpha_num')->translate();
    }
}
