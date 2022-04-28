<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
          'fullNameInput' => ['sometimes', 'nullable', 'regex:/[A-Za-z0-9 ]+/u', 'min: 2', 'max: 255'],
          'emailInput' =>
            [
              'sometimes',
              'nullable', 'regex:/\S+@\S+\.\S+/u',
              Rule::unique('users', 'email')->ignore(Auth::id()),
              'min: 3',
              'max: 255'
            ],
          'phoneNumberInput' =>
            [
              'sometimes',
              'nullable', 'regex:/^[0-9]{10}$/u',
              Rule::unique('users', 'phone_number')->ignore(Auth::id()),
              'size: 10'
            ],
          'usernameInput' =>
            [
              'sometimes',
              'nullable', 'regex:/[A-Za-z0-9]+/u',
              Rule::unique('users', 'username')->ignore(Auth::id()),
              'min: 1',
              'max: 255'
            ],
        ];
    }
}
