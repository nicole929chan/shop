<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class ActivityStoreRequest extends FormRequest
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
            'member_id' => 'required|exists:members,id',
            'points' => 'numeric|min:1',
            'description' => 'required',
            'activity_start' => 'date',
            'activity_end' => 'date|after:activity_start',
            'image_path' => 'required|image'
        ];
    }
}
