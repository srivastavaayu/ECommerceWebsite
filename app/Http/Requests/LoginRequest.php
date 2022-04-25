<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        'UsernameInput' => ['sometimes', 'required', 'min: 1', 'max: 255'],
        'PasswordInput' => ['sometimes', 'required', 'min: 1', 'max: 255']
      ];
    }

    public function messages()
    {
      return [
        'UsernameInput.required' => 'Username is required!',
        'PasswordInput.required' => 'Password is required!'
      ];
    }
}
