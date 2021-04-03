<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValueRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regex = '/^\d*(\.|,)\d{0,4}$/';

		if (preg_match($regex, $value) !== 1) {
			return false;
		}

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid :attribute, correct format is 0,0000 or 0.0000';
    }
}
