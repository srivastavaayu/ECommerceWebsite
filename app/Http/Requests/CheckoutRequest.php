<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        'AddressLine1Input' => ['sometimes', 'required'],
        'AddressLine2Input' => ['sometimes', 'required'],
        'CityInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u'],
        'StateInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u'],
        'CountryInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u'],
        'PINCodeInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u'],
      ];
    }
}
