<?php

namespace App\Http\Requests;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
    public function rules(User $user)
    {
        return [
            'phone_number' => 'min:10|numeric',
            'filename' => 'mimes:png, jpg, jpeg',
            'gender' => 'in:1, 2',
            'status' => 'in:1, 2, 3'

        ];
    }
}
