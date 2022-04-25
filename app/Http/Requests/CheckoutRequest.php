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
        'AddressLine1Input' => ['sometimes', 'required', 'min: 3', 'max: 255'],
        'AddressLine2Input' => ['sometimes', 'required', 'min: 3', 'max: 255'],
        'CityInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u', 'min: 1', 'max: 255'],
        'StateInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u', 'min: 1', 'max: 255'],
        'CountryInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u', 'min: 1', 'max: 255'],
        'PINCodeInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u', 'min: 3', 'max: 10'],
      ];
    }
}
