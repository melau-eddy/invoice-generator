<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => ['string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
                    'location' => ['string'],
                    'phone_number' => ['required, min:10, numeric'],
                    'company_image' => ['required, mimes:png, jpg, jpeg']
                ];

            case 'PUT':
                return [
                    'name' => ['string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'location' => ['string'],
                    'phone_number' => ['required, min:10, numeric'],
                    'company_image' => ['required, mimes:png, jpg, jpeg']
                ];
            default:
                break;
        }
    }
}

