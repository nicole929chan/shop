<?php

namespace App\Http\Requests\Redeem;

use App\Rules\EnoughPoints;
use App\Rules\MustHavePlan;
use Illuminate\Foundation\Http\FormRequest;

class RedeemStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_code' => ['required', 'exists:users,code', new MustHavePlan(request('member_code')), new EnoughPoints(request('member_code'), request('points'))],
            'member_code' => ['required' ,'exists:members,code'],
            'points' => 'numeric|min:1'
        ];
    }
}
