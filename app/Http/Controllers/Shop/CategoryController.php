<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

  public $sortBehavior = 'none';
  public $sortField = 'id';
  public $sortDirection = 'ASC';

  public function showCategories(Request $request)
  {
    try
    {
      $categories = Category::getCategories(true, 2);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return view('shop/categories', ['categories' => $categories]);
  }

  public function showCategory(Request $request, $id)
  {
    $urlParameters = [
      'id' => $id,
    ];
    $validator = Validator::make($urlParameters, [
      'id' => ['required', 'numeric', 'integer']
    ]);
    // if (!is_numeric($id)) {
    //   return view('404');
    // }
    if ($validator->fails()) {
      return view('422');
    }
    if ($request -> has('sort'))
    {
      switch ($request -> sort)
      {
        case "priceASC":
          $this -> sortBehavior = 'priceASC';
          $this -> sortField = 'price';
          $this -> sortDirection = 'ASC';
          break;
        case "priceDESC":
          $this -> sortBehavior = 'priceDESC';
          $this -> sortField = 'price';
          $this -> sortDirection = 'DESC';
          break;
        case "ratingASC":
          $this -> sortBehavior = 'ratingASC';
          $this -> sortField = 'rating';
          $this -> sortDirection = 'ASC';
          break;
        case "ratingDESC":
          $this -> sortBehavior = 'ratingDESC';
          $this -> sortField = 'rating';
          $this -> sortDirection = 'DESC';
          break;
        default:
          $this -> sortBehavior = 'none';
          $this -> sortField = 'id';
          $this -> sortDirection = 'ASC';
          break;
      }
    }
    try
    {
      $category = Category::getCategory($id);
      if (empty($category)) {
        $resource = "Category";
        $resourceSmall = "category";
        return view('custom404', ['resource' => $resource, 'resourceSmall' => $resourceSmall]);
      }
      $products = Product::getProducts(
        null,
        $id,
        0,
        [$this -> sortField, $this -> sortDirection],
        true,
        3
      );
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return view('shop/category',
      [
        'category' => $category,
        'products' => $products,
        'sortBehavior' => $this -> sortBehavior
      ]
    );
  }

}
