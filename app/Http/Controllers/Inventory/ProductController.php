<?php

namespace App\Http\Controllers\Inventory;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

  public $sortBehavior = "ASC";

  public function products(Request $request) {
    $info = "";
    if ($request -> has('sort')) {
      $this -> sortBehavior = $request -> sort;
    }
    if ($request -> isMethod('POST')) {
      $product = Product::find($request -> productId);
      if ($product -> is_archived) {
        $product -> is_archived = 0;
        $info = "Product unarchived successfully!";
      }
      else {
        $product -> is_archived = 1;
        $info = "Product archived successfully!";
      }
      $product -> save();
    }
    $allProducts = Product::where('user_id', Auth::id()) -> orderBy('updated_at', $this -> sortBehavior) -> get();
    $activeProducts = Product::where([['user_id', Auth::id()], ['is_archived', 0]]) -> orderBy('updated_at', $this -> sortBehavior) -> get();
    $archivedProducts = Product::where([['user_id', Auth::id()], ['is_archived', 1]]) -> orderBy('updated_at', $this -> sortBehavior) -> get();
    $categories = Category::all();
    return view('inventory/products', ['allProducts' => $allProducts, 'activeProducts' => $activeProducts, 'archivedProducts' => $archivedProducts, 'categories' => $categories, 'sortBehavior' => $this -> sortBehavior, 'info' => $info]);
  }

  public function product(Request $request, $id) {
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
      if ($request -> hasFile('ProductImageInput')) {
        $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
        $product -> image_path = $productImageInputPath;
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

  public function addNewProduct(Request $request) {
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
          'ProductImageInput'  =>  'file|mimes:jpeg,png,gif,jpg,webp,jfif',
          'PriceInput' => ['required', 'min:1'],
          'UnitInput' => ['required'],
          'StockQuantityInput' => ['required', 'min:1'],
        ]);

        if($validator -> fails()) {
          return redirect('/inventory/product/add-new-product') -> withErrors($validator) -> withInput();
        }
        $product = new Product;
        $product -> category_id = $request -> CategoryInput;
        $product -> sku = $request -> SKUInput;
        $product -> name = $request -> ProductNameInput;
        $product -> description = $request -> ProductDescriptionInput;
        $product -> user_id = Auth::id();
        if ($request -> hasFile('ProductImageInput')) {
          $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
          $product -> image_path = $productImageInputPath;
        }
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
