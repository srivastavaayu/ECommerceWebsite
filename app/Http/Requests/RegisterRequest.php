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
        'FullNameInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9 ]+/u', 'min: 2', 'max: 255'],
        'EmailInput' => ['sometimes', 'required', 'regex:/\S+@\S+\.\S+/u', 'unique:users,email', 'min: 3', 'max: 255'],
        'PhoneNumberInput' => ['sometimes', 'required', 'regex:/^[0-9]{10}$/u', 'unique:users,phone_number', 'size: 10'],
        'UsernameInput' => ['sometimes', 'required', 'regex:/[A-Za-z0-9]+/u', 'unique:users,username', 'min: 1', 'max: 255'],
        'PasswordInput' => ['sometimes', 'required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'min: 1', 'max: 255'],
        'ReenterPasswordInput' => ['sometimes', 'required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'same:PasswordInput', 'min: 1', 'max: 255'],
      ];
    }
}
