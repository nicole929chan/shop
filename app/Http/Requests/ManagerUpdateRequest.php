<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerUpdateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:members,email,'.$this->member->id,
            'phone_number' => 'required',
            'address' => 'required',
            'start_date' => 'required|date',
            'finish_date' => 'required|date|after:start_date'
        ];
    }
}
