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
        'AddressLine1Input' => ['required'],
        'AddressLine2Input' => ['required'],
        'CityInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'StateInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'CountryInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'PINCodeInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
      ];
    }
}
