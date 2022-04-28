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
        'usernameInput' => ['sometimes', 'required', 'min: 1', 'max: 255'],
        'passwordInput' => ['sometimes', 'required', 'min: 1', 'max: 255']
      ];
    }

    public function messages()
    {
      return [
        'usernameInput.required' => 'Username is required!',
        'passwordInput.required' => 'Password is required!'
      ];
    }
}
