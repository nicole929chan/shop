<?php

namespace App\Rules;

use App\Models\Member;
use Illuminate\Contracts\Validation\Rule;

class ValidActivity implements Rule
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
        $member = Member::whereCode($value)->first();

        if($member) {
            return $member->activity->getValid();
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The activity has closed.';
    }
}
