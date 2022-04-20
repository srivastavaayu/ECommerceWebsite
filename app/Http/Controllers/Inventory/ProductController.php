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
use App\Http\Requests\NewProductRequest;

class ProductController extends Controller
{

  public $sortBehavior = "ASC";
  public $viewStyle = "tabular";

  public function getProducts(Request $request)
  {
    $info = "";
    if ($request -> has('sort'))
    {
      $this -> sortBehavior = $request -> sort;
    }
    $allProducts = Product::getProducts(
      [['user_id', Auth::id()]],
      null,
      null,
      ['updated_at', $this -> sortBehavior]
    ) -> get();
    $activeProducts = Product::getProducts(
      [['user_id', Auth::id()], ['is_archived', 0]],
      null,
      null,
      ['updated_at', $this -> sortBehavior]
    ) -> get();
    $archivedProducts = Product::getProducts(
      [['user_id', Auth::id()],
      ['is_archived', 1]],
      null,
      null,
      ['updated_at', $this -> sortBehavior]
    ) -> get();
    $categories = Category::getCategories() -> get();
    return view('inventory/products',
      [
        'allProducts' => $allProducts,
        'activeProducts' => $activeProducts,
        'archivedProducts' => $archivedProducts,
        'categories' => $categories,
        'sortBehavior' => $this -> sortBehavior,
        'viewStyle' => $this -> viewStyle,
        'info' => $info
      ]
    );
  }

  public function postProducts(Request $request)
  {
    $info = "";
    if ($request -> has('sort'))
    {
      $this -> sortBehavior = $request -> sort;
    }
    if ($request -> has('view'))
    {
      $this -> viewStyle = $request -> view;
    }
    else
    {
      $product = Product::getProduct([['id', $request -> productId]]);
      if ($product -> is_archived)
      {
        Product::setProduct([['id', $request -> productId]], ['is_archived' => 0]);
        $info = "Product unarchived successfully!";
      }
      else
      {
        Product::setProduct([['id', $request -> productId]], ['is_archived' => 1]);
        $info = "Product archived successfully!";
      }
    }
    $allProducts = Product::getProducts(
      [['user_id', Auth::id()]],
      null,
      null,
      ['updated_at', $this -> sortBehavior]
    ) -> get();
    $activeProducts = Product::getProducts(
      [['user_id', Auth::id()], ['is_archived', 0]],
      null,
      null,
      ['updated_at', $this -> sortBehavior]
    ) -> get();
    $archivedProducts = Product::getProducts(
      [['user_id', Auth::id()],
      ['is_archived', 1]],
      null,
      null,
      ['updated_at', $this -> sortBehavior]
    ) -> get();
    $categories = Category::getCategories() -> get();
    return view('inventory/products',
      [
        'allProducts' => $allProducts,
        'activeProducts' => $activeProducts,
        'archivedProducts' => $archivedProducts,
        'categories' => $categories,
        'sortBehavior' => $this -> sortBehavior,
        'viewStyle' => $this -> viewStyle,
        'info' => $info
      ]
    );
  }

  public function getProduct(Request $request, $id)
  {
    $info = "";
    $product = Product::getProduct([['id', $id]]);
    $categories = Category::getCategories() -> get();
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function postProduct(Request $request, $id)
  {
    $info = "";
    $product = Product::getProduct([['id', $id]]);
    $data = [];
    if (($request -> ProductNameInput) != ($product -> name) && (!is_null($request -> ProductNameInput)))
    {
      $data['name'] = $request -> ProductNameInput;
    }
    if (($request -> ProductDescriptionInput) != ($product -> description) && (!is_null($request -> ProductDescriptionInput)))
    {
      $data['description'] = $request -> ProductDescriptionInput;

    }
    if (($request -> SKUInput) != ($product -> sku) && (!is_null($request -> SKUInput)))
    {
      $data['sku'] = $request -> SKUInput;

    }
    if (($request -> CategoryInput) != ($product -> category_id) && (!is_null($request -> CategoryInput)))
    {
      $data['category_id'] = $request -> CategoryInput;

    }
    if ($request -> hasFile('ProductImageInput'))
    {
      $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
      $product -> image_path = $productImageInputPath;
      $data['image_path'] = $productImageInputPath;
    }
    if (($request -> PriceInput) != ($product -> price) && (!is_null($request -> PriceInput)))
    {
      $data['price'] = $request -> PriceInput;
    }
    if (($request -> UnitInput) != ($product -> unit) && (!is_null($request -> UnitInput)))
    {
      $data['unit'] = $request -> UnitInput;
    }
    if (($request -> StockQuantityInput) != ($product -> quantity) && (!is_null($request -> StockQuantityInput)))
    {
      $data['quantity'] = $request -> StockQuantityInput;
    }
    if (count($data) > 0)
    {
      Product::setProduct([['id', $id]], $data);
      $info = "Product updated successfully!";
    }
    $product = Product::getProduct([['id', $id]]);
    $categories = Category::getCategories() -> get();
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function getAddNewProduct(Request $request)
  {
    $categories = Category::getCategories() -> get();
    return view('inventory/add-new-product', ['categories' => $categories]);
  }

  public function postAddNewProduct(NewProductRequest $request)
  {
    if ($request -> action == "AddNewCategory")
    {
      $category = Category::addCategory(
        [
          'name' => $request -> CategoryNameInput,
          'description' => $request -> CategoryDescriptionInput
        ]
      );
      return redirect('/inventory/product/add-new-product');
    }
    else {
      if ($request -> hasFile('ProductImageInput'))
      {
        $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
      }
      $product = Product::addProduct(
        [
          'user_id' => Auth::id(),
          'category_id' => $request -> CategoryInput,
          'sku' => $request -> SKUInput,
          'name' => $request -> ProductNameInput,
          'description' => $request -> ProductDescriptionInput,
          'image_path' => $productImageInputPath,
          'price' => $request -> PriceInput,
          'unit' => $request -> UnitInput,
          'quantity' => $request -> StockQuantityInput,
          'is_archived' => 0,
          'rating' => 0
        ]
      );
      return redirect('/inventory/product');
    }
  }

}
