<?php

namespace App\Rules;

use App\Models\User;
use App\Models\Member;
use Illuminate\Contracts\Validation\Rule;

class EnoughPoints implements Rule
{
    protected $memberCode;

    protected $points;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($memberCode, $points)
    {
        $this->memberCode = $memberCode;

        $this->points = $points;
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

        if(is_null($user) || is_null($member)) {
            return false;
        } else {
            $item = $user->pointByMember($member->id)->first();

            if($item) {
                return $item->pivot->points >= $this->points;
            }
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
        return 'Your points are not enough.';
    }
}
