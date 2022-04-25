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

  public function showProducts(Request $request)
  {
    $info = "";
    if ($request -> has('sort'))
    {
      $this -> sortBehavior = $request -> sort;
    }
    try
    {
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
    }
    catch(Exception $e)
    {
      return view('404');
    }
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

  public function storeProducts(Request $request)
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
      try
      {
        $product = Product::getProduct([['id', $request -> productId]]);
      }
      catch(Exception $e)
      {
        return view('404');
      }
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
    try
    {
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
    }
    catch(Exception $e)
    {
      return view('404');
    }
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

  public function showProduct(Request $request, $id)
  {
    $info = "";
    try
    {
      $product = Product::getProduct([['id', $id]]);
      $categories = Category::getCategories() -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function storeProduct(Request $request, $id)
  {
    $info = "";
    try
    {
      $product = Product::getProduct([['id', $id]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
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
    try
    {
      $product = Product::getProduct([['id', $id]]);
      $categories = Category::getCategories() -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function showAddNewProduct(Request $request)
  {
    try
    {
      $categories = Category::getCategories() -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return view('inventory/new-product', ['categories' => $categories]);
  }

  public function storeAddNewProduct(NewProductRequest $request)
  {
    if ($request -> action == "AddNewCategory")
    {
      try
      {
        $category = Category::addCategory(
          [
            'name' => $request -> CategoryNameInput,
            'description' => $request -> CategoryDescriptionInput
          ]
        );
      }
      catch(Exception $e)
      {
        return view('404');
      }
      return redirect('/inventory/product/new-product');
    }
    else {
      if ($request -> hasFile('ProductImageInput'))
      {
        $productImageInputPath = Storage::putFile('public', $request -> ProductImageInput);
      }
      try
      {
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
            'units_sold' => 0,
            'is_archived' => 0,
            'rating' => 0
          ]
        );
      }
      catch(Exception $e)
      {
        return view('404');
      }
      return redirect('/inventory/product');
    }
  }

}
