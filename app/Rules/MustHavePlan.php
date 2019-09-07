<?php

namespace App\Rules;

use App\Models\Member;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class MustHavePlan implements Rule
{
    protected $memberCode;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($memberCode)
    {
        $this->memberCode = $memberCode;
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
        $user = User::whereCode($value)->first();
        $member = Member::whereCode($this->memberCode)->first();

        $user = User::where('id', $user->id)->whereHas('plans', function ($q) use ($member) {
            $q->where('member_id', $member->id);
        })->first();

       if (is_null($user)) {
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
        return 'The user doesn\'t join your plan.';
    }
}
