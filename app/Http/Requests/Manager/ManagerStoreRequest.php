<?php

namespace App\Http\Requests\Manager;

use App\Rules\MustHaveImage;
use Illuminate\Foundation\Http\FormRequest;

class ManagerStoreRequest extends FormRequest
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
            'admin' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:members',
            'start_date' => 'required|date',
            'finish_date' => 'required|date|after:start_date',
            'image' => 'required_if:admin,0'
        ];
    }
}
