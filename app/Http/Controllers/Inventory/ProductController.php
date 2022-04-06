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
  public $viewStyle = "tabular";

  public function products(Request $request)
  {
    $info = "";
    if ($request -> has('sort'))
    {
      $this -> sortBehavior = $request -> sort;
    }
    if ($request -> isMethod('POST'))
    {
      if ($request -> has('view'))
      {
        $this -> viewStyle = $request -> view;
      }
      else
      {
        $product = Product::getProduct([['id', $request -> productId]]);
        if ($product -> is_archived)
        {
          Product::setProduct([['id', $request -> productId]], [['is_archived', 0]]);
          $info = "Product unarchived successfully!";
        }
        else
        {
          Product::setProduct([['id', $request -> productId]], [['is_archived', 1]]);
          $info = "Product archived successfully!";
        }
      }
    }
    $allProducts = Product::getProducts([['user_id', Auth::id()]], null, null, ['updated_at', $this -> sortBehavior]) -> get();
    $activeProducts = Product::getProducts([['user_id', Auth::id()], ['is_archived', 0]], null, null, ['updated_at', $this -> sortBehavior]) -> get();
    $archivedProducts = Product::getProducts([['user_id', Auth::id()], ['is_archived', 1]], null, null, ['updated_at', $this -> sortBehavior]) -> get();
    $categories = Category::getCategories() -> get();
    return view('inventory/products', ['allProducts' => $allProducts, 'activeProducts' => $activeProducts, 'archivedProducts' => $archivedProducts, 'categories' => $categories, 'sortBehavior' => $this -> sortBehavior, 'viewStyle' => $this -> viewStyle, 'info' => $info]);
  }

  public function product(Request $request, $id)
  {
    $info = "";
    $product = Product::getProduct([['id', $id]], null, null, null);
    if ($request -> isMethod("POST"))
    {
      $data = [];
      if (($request -> ProductNameInput) != ($product -> name) && (!is_null($request -> ProductNameInput)))
      {
        array_push($data, ['name', $request -> ProductNameInput]);
      }
      if (($request -> ProductDescriptionInput) != ($product -> description) && (!is_null($request -> ProductDescriptionInput)))
      {
        array_push($data, ['description', $request -> ProductDescriptionInput]);

      }
      if (($request -> SKUInput) != ($product -> sku) && (!is_null($request -> SKUInput)))
      {
        array_push($data, ['sku', $request -> SKUInput]);

      }
      if (($request -> CategoryInput) != ($product -> category_id) && (!is_null($request -> CategoryInput)))
      {
        array_push($data, ['category_id', $request -> CategoryInput]);

      }
      if ($request -> hasFile('ProductImageInput'))
      {
        $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
        $product -> image_path = $productImageInputPath;
        array_push($data, ['image_path', $productImageInputPath]);
      }
      if (($request -> PriceInput) != ($product -> price) && (!is_null($request -> PriceInput)))
      {
        $product -> price = $request -> PriceInput;
        array_push($data, ['price', $request -> PriceInput]);
      }
      if (($request -> UnitInput) != ($product -> unit) && (!is_null($request -> UnitInput)))
      {
        $product -> unit = $request -> UnitInput;
        array_push($data, ['unit', $request -> UnitInput]);
      }
      if (($request -> StockQuantityInput) != ($product -> quantity) && (!is_null($request -> StockQuantityInput)))
      {
        $product -> quantity = $request -> StockQuantityInput;
        array_push($data, ['quantity', $request -> StockQuantityInput]);
      }
      if (count($data) > 0)
      {
        Product::setProduct([['id', $id]], $data);
        $info = "Product updated successfully!";
      }
    }
    $product = Product::getProduct([['id', $id]]);
    $categories = Category::getCategories() -> get();
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function addNewProduct(Request $request)
  {
    if ($request -> isMethod('POST'))
    {
      if ($request -> action == "AddNewCategory")
      {
        $validator = Validator::make($request -> all(),
          [
            'CategoryNameInput' => ['required'],
            'CategoryDescriptionInput' => ['required'],
          ]
        );

        if($validator -> fails())
        {
          return redirect('/inventory/product/add-new-product') -> withErrors($validator) -> withInput();
        }
        $category = Category::addCategory(['name' => $request -> CategoryNameInput, 'description' => $request -> CategoryDescriptionInput]);
        return redirect('/inventory/product/add-new-product');
      }
      else {
        $validator = Validator::make($request -> all(),
          [
            'ProductNameInput' => ['required'],
            'ProductDescriptionInput' => ['required'],
            'SKUInput' => ['required', 'unique:products,sku'],
            'CategoryInput' => ['required', 'exists:categories,id'],
            'ProductImageInput'  =>  'file|mimes:jpeg,png,gif,jpg,webp,jfif',
            'PriceInput' => ['required', 'min:1'],
            'UnitInput' => ['required'],
            'StockQuantityInput' => ['required', 'min:1'],
          ]
        );

        if($validator -> fails())
        {
          return redirect('/inventory/product/add-new-product') -> withErrors($validator) -> withInput();
        }
        if ($request -> hasFile('ProductImageInput'))
        {
          $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
        }
        $product = Product::addProduct(['user_id' => Auth::id(), 'category_id' => $request -> CategoryInput, 'sku' => $request -> SKUInput, 'name' => $request -> ProductNameInput, 'description' => $request -> ProductDescriptionInput, 'image_path' => $productImageInputPath, 'price' => $request -> PriceInput, 'unit' => $request -> UnitInput, 'quantity' => $request -> StockQuantityInput, 'is_archived' => 0, 'rating' => 0]);
        return redirect('/inventory/product');
      }
    }
    $categories = Category::getCategories() -> get();
    return view('inventory/add-new-product', ['categories' => $categories]);
  }

}
