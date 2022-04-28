<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        'productNameInput' => ['sometimes', 'required', 'min: 1', 'max: 255'],
        'productDescriptionInput' => ['sometimes', 'required', 'min: 1', 'max: 16777215'],
        'skuInput' => ['sometimes', 'required', 'unique:products,sku', 'min: 1', 'max: 255'],
        'categoryInput' => ['sometimes', 'required', 'exists:categories,id'],
        'productImageInput'  =>  'file|mimes:jpeg,png,gif,jpg,webp,jfif',
        'priceInput' => ['sometimes', 'required', 'min:1'],
        'unitInput' => ['sometimes', 'required', 'min:1'],
        'stockQuantityInput' => ['sometimes', 'required', 'min:1'],
      ];
    }
}
