<?php

namespace App\Http\Controllers\Inventory;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddNewProductController extends Controller
{
  public function handle(Request $request) {
    if ($request -> isMethod('POST')) {
      if ($request -> action == "AddNewCategory") {
        $validator = Validator::make($request -> all(), [
          'CategoryNameInput' => ['required'],
          'CategoryDescriptionInput' => ['required'],
        ]);

        if($validator -> fails()) {
          return redirect('/inventory/product/add-new-product') -> withErrors($validator) -> withInput();
        }
        $category = new Category;
        $category -> name = $request -> CategoryNameInput;
        $category -> description = $request -> CategoryDescriptionInput;
        $category -> save();
        return redirect('/inventory/product/add-new-product');
      }
      else {
        $validator = Validator::make($request -> all(), [
          'ProductNameInput' => ['required'],
          'ProductDescriptionInput' => ['required'],
          'SKUInput' => ['required', 'unique:products,sku'],
          'CategoryInput' => ['required', 'exists:categories,id'],
          'PriceInput' => ['required', 'min:1'],
          'UnitInput' => ['required'],
          'StockQuantityInput' => ['required', 'min:1'],
        ]);

        if($validator -> fails()) {
          return redirect('/inventory/product/add-new-product') -> withErrors($validator) -> withInput();
        }
        $product = new Product;
        $product -> name = $request -> ProductNameInput;
        $product -> description = $request -> ProductDescriptionInput;
        $product -> sku = $request -> SKUInput;
        $product -> category_id = $request -> CategoryInput;
        $product -> user_id = Auth::id();
        $product -> price = $request -> PriceInput;
        $product -> unit = $request -> UnitInput;
        $product -> quantity = $request -> StockQuantityInput;
        $product -> is_archived = 0;
        $product -> save();
        return redirect('/inventory/product');
      }
    }
    $categories = Category::all();
    return view('inventory/add-new-product', ['categories' => $categories]);
  }
}
