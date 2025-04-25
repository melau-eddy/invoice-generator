<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'iName*'=>['required', 'string'],
            'qty*'=>['required', 'integer'],
            'cost*'=>['required', 'numeric'],
            'iName'=>['required','array'],
            'discount'=>['required', 'numeric'],
            'tax'=>['required', 'numeric'],
            'due'=>['required', 'numeric'],
            'advance'=>['required', 'numeric'],
            'dcost'=>['required', 'numeric'],
            'cost_wod'=>['required', 'numeric'],
//            'addForm'=>['required', 'array', 'min:1']

        ];
    }
}
