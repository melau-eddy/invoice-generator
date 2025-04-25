<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class UserRequest extends FormRequest
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
        switch($this->method()) {
            case 'POST':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed']

                ];

            case 'PUT':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'phone_number' => ['min:10|numeric'],
                    'profile_pic' => ['mimes:png, jpg, jpeg'],
                    'gender' => ['in:1, 2'],
                    'status' => ['in:1, 2, 3']
                ];
            default:break;

        }
    }
}
