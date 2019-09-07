<?php

namespace App\Http\Requests\Point;

use App\Rules\MustHavePlan;
use App\Rules\ValidActivity;
use Illuminate\Foundation\Http\FormRequest;

class PointStoreRequest extends FormRequest
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
            'user_code' => ['required', 'exists:users,code', new MustHavePlan(request('member_code'))],
            'member_code' => ['required' ,'exists:members,code', new ValidActivity()],
            'points' => 'numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
            'member_code.required' => 'Your code is required.',
        ];
    }
}
