<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
  public $sortBehavior = 'none';
  public $sortField = 'id';
  public $sortDirection = 'ASC';
  public function handle(Request $request) {
    if ($request -> has('sort')) {
      switch ($request -> sort) {
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
    if ($request -> isMethod('POST')) {

    }
    $products = Product::where('is_archived', 0) -> orderBy($this -> sortField, $this -> sortDirection) -> simplePaginate(3);
    return view('shop/products',['products' => $products, 'sortBehavior' => $this -> sortBehavior]);
  }

}
