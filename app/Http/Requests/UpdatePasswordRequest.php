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
        'CurrentPasswordInput' =>
          [
            'sometimes',
            'required',
            'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u',
            'min: 1',
            'max: 255'
          ],
        'PasswordInput' =>
          [
            'sometimes',
            'required',
            'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u',
            'min: 1',
            'max: 255'
          ],
        'ReenterPasswordInput' =>
          [
            'sometimes',
            'required',
            'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u',
            'same:PasswordInput',
            'min: 1',
            'max: 255'
          ]
      ];
    }
}
