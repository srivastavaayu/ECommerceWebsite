<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        'FullNameInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'EmailInput' => ['required', 'regex:/\S+@\S+\.\S+/u', 'unique:users,email'],
        'PhoneNumberInput' => ['required', 'regex:/^[0-9]{10}$/u', 'unique:users,phone_number'],
        'UsernameInput' => ['required', 'regex:/[A-Za-z0-9]+/u', 'unique:users,username'],
        'PasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
        'ReenterPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'same:PasswordInput'],
      ];
    }
}
