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
    public function rules()
    {
        return [
          'CategoryNameInput' => ['required'],
          'CategoryDescriptionInput' => ['required'],
          'ProductNameInput' => ['required'],
          'ProductDescriptionInput' => ['required'],
          'SKUInput' => ['required', 'unique:products,sku'],
          'CategoryInput' => ['required', 'exists:categories,id'],
          'ProductImageInput'  =>  'file|mimes:jpeg,png,gif,jpg,webp,jfif',
          'PriceInput' => ['required', 'min:1'],
          'UnitInput' => ['required'],
          'StockQuantityInput' => ['required', 'min:1'],
        ];
    }
}
