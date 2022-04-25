<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
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
    public function rules() {
      return [
        'CategoryNameInput' => ['sometimes', 'required', 'min: 1', 'max: 255'],
        'CategoryDescriptionInput' => ['sometimes', 'required', 'min: 1', 'max: 255'],
        'ProductNameInput' => ['sometimes', 'required', 'min: 1', 'max: 255'],
        'ProductDescriptionInput' => ['sometimes', 'required', 'min: 1', 'max: 16777215'],
        'SKUInput' => ['sometimes', 'required', 'unique:products,sku', 'min: 1', 'max: 255'],
        'CategoryInput' => ['sometimes', 'required', 'exists:categories,id'],
        'ProductImageInput'  =>  'file|mimes:jpeg,png,gif,jpg,webp,jfif',
        'PriceInput' => ['sometimes', 'required', 'min:1'],
        'UnitInput' => ['sometimes', 'required', 'min:1'],
        'StockQuantityInput' => ['sometimes', 'required', 'min:1'],
      ];
    }
}
