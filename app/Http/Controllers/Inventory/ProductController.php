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
use App\Http\Requests\ProductRequest;

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
      );
      $activeProducts = Product::getProducts(
        [['user_id', Auth::id()], ['is_archived', 0]],
        null,
        null,
        ['updated_at', $this -> sortBehavior]
      );
      $archivedProducts = Product::getProducts(
        [['user_id', Auth::id()],
        ['is_archived', 1]],
        null,
        null,
        ['updated_at', $this -> sortBehavior]
      );
      $categories = Category::getCategories();
    }
    catch(Exception $e)
    {
      return view('500');
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
        if (empty($product)) {
          return view('404');
        }
      }
      catch(Exception $e)
      {
        return view('500');
      }
      if ($product -> is_archived)
      {
        $setProductStatus = Product::setProduct([['id', $request -> productId]], ['is_archived' => 0]);
        if ($setProductStatus)
          $info = "Product unarchived successfully!";
      }
      else
      {
        $setProductStatus = Product::setProduct([['id', $request -> productId]], ['is_archived' => 1]);
        if ($setProductStatus)
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
      );
      $activeProducts = Product::getProducts(
        [['user_id', Auth::id()], ['is_archived', 0]],
        null,
        null,
        ['updated_at', $this -> sortBehavior]
      );
      $archivedProducts = Product::getProducts(
        [['user_id', Auth::id()],
        ['is_archived', 1]],
        null,
        null,
        ['updated_at', $this -> sortBehavior]
      );
      $categories = Category::getCategories();
    }
    catch(Exception $e)
    {
      return view('500');
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
    if (!is_numeric($id)) {
      return view('404');
    }
    $info = "";
    try
    {
      $product = Product::getProduct([['id', $id]]);
      $categories = Category::getCategories();
      if (empty($product) || ($product -> user_id != Auth::id()) || empty($categories)) {
        return view('404');
      }
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function storeProduct(ProductRequest $request, $id)
  {
    if (!is_numeric($id)) {
      return view('404');
    }
    $info = "";
    try
    {
      $product = Product::getProduct([['id', $id]]);
      if (empty($product) || ($product -> user_id != Auth::id())) {
        return view('404');
      }
    }
    catch(Exception $e)
    {
      return view('500');
    }
    $data = [];
    if ((!is_null($request -> productNameInput)) && ($request -> productNameInput) != ($product -> name))
    {
      $data['name'] = $request -> productNameInput;
    }
    if ((!is_null($request -> productDescriptionInput)) && ($request -> productDescriptionInput) != ($product -> description))
    {
      $data['description'] = $request -> productDescriptionInput;

    }
    if ((!is_null($request -> skuInput)) && ($request -> skuInput) != ($product -> sku))
    {
      $data['sku'] = $request -> skuInput;

    }
    if ((!is_null($request -> categoryInput)) && ($request -> categoryInput) != ($product -> category_id))
    {
      $data['category_id'] = $request -> categoryInput;

    }
    if ($request -> hasFile('productImageInput'))
    {
      $productImageInputPath = Storage::putFile('public', $request -> productImageInput);
      $product -> image_path = $productImageInputPath;
      $data['image_path'] = $productImageInputPath;
    }
    if ((!is_null($request -> priceInput)) && ($request -> priceInput) != ($product -> price))
    {
      $data['price'] = $request -> priceInput;
    }
    if ((!is_null($request -> unitInput)) && ($request -> unitInput) != ($product -> unit))
    {
      $data['unit'] = $request -> unitInput;
    }
    if ((!is_null($request -> stockQuantityInput)) && ($request -> stockQuantityInput) != ($product -> quantity))
    {
      $data['quantity'] = $request -> stockQuantityInput;
    }
    if (count($data) > 0)
    {
      $setProductStatus = Product::setProduct([['id', $id]], $data);
      if ($setProductStatus)
        $info = "Product updated successfully!";
    }
    try
    {
      $product = Product::getProduct([['id', $id]]);
      $categories = Category::getCategories();
      if (empty($product) || empty($categories)) {
        return view('404');
      }
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return view('inventory/product', ['product' => $product, 'categories' => $categories, 'info' => $info]);
  }

  public function showAddNewProduct(Request $request)
  {
    try
    {
      $categories = Category::getCategories();
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return view('inventory/new-product', ['categories' => $categories]);
  }

  public function storeAddNewProduct(ProductRequest $request)
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
        if (empty($category)) {
          return view('404');
        }
      }
      catch(Exception $e)
      {
        return view('500');
      }
      return redirect('/inventory/product/new-product');
    }
    else {
      if ($request -> hasFile('productImageInput'))
      {
        $productImageInputPath = Storage::putFile('public', $request -> productImageInput);
      }
      try
      {
        $product = Product::addProduct(
          [
            'user_id' => Auth::id(),
            'category_id' => $request -> categoryInput,
            'sku' => $request -> skuInput,
            'name' => $request -> productNameInput,
            'description' => $request -> productDescriptionInput,
            'image_path' => $productImageInputPath,
            'price' => $request -> priceInput,
            'unit' => $request -> unitInput,
            'quantity' => $request -> stockQuantityInput,
            'units_sold' => 0,
            'is_archived' => 0,
            'rating' => 0
          ]
        );
        if (empty($product)) {
          return view('404');
        }
      }
      catch(Exception $e)
      {
        return view('500');
      }
      return redirect('/inventory/product');
    }
  }

}
