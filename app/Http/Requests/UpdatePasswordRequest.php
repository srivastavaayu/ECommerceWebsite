<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
        'currentPasswordInput' =>
          [
            'sometimes',
            'required',
            'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u',
            'min: 1',
            'max: 255'
          ],
        'passwordInput' =>
          [
            'sometimes',
            'required',
            'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u',
            'min: 1',
            'max: 255'
          ],
        'reenterPasswordInput' =>
          [
            'sometimes',
            'required',
            'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u',
            'same:passwordInput',
            'min: 1',
            'max: 255'
          ]
      ];
    }
}
