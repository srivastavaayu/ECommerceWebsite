<?php

namespace App\Http\Controllers\Inventory;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

  public function handle(Request $request, $id) {
    $info = "";
    $product = Product::find($id);
    if ($request -> isMethod("POST")) {
      if (($request -> ProductNameInput) != ($product -> name) && (!is_null($request -> ProductNameInput))) {
        $product -> name = $request -> ProductNameInput;
      }
      if (($request -> ProductDescriptionInput) != ($product -> description) && (!is_null($request -> ProductDescriptionInput))) {
        $product -> description = $request -> ProductDescriptionInput;
      }
      if (($request -> SKUInput) != ($product -> sku) && (!is_null($request -> SKUInput))) {
        $product -> sku = $request -> SKUInput;
      }
      if (($request -> CategoryInput) != ($product -> category_id) && (!is_null($request -> CategoryInput))) {
        $product -> category_id = $request -> CategoryInput;
      }
      if (($request -> PriceInput) != ($product -> price) && (!is_null($request -> PriceInput))) {
        $product -> price = $request -> PriceInput;
      }
      if (($request -> UnitInput) != ($product -> unit) && (!is_null($request -> UnitInput))) {
        $product -> unit = $request -> UnitInput;
      }
      if (($request -> StockQuantityInput) != ($product -> quantity) && (!is_null($request -> StockQuantityInput))) {
        $product -> quantity = $request -> StockQuantityInput;
      }
      $product -> save();
      $info = "Product updated successfully!";
    }
    $product = Product::find($id);
    $categories = Category::all();
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

}
