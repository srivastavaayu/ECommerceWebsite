<?php

namespace App\Http\Controllers\Shop;

use App\User;
use App\Product;
use App\Category;
use App\Cart;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

  public $sortBehavior = 'none';
  public $sortField = 'id';
  public $sortDirection = 'ASC';

  public function showProducts(Request $request)
  {
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
      $products = Product::getProducts(
        null,
        null,
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
      return view('shop/products',
      [
        'products' => $products,
        'sortBehavior' => $this -> sortBehavior
      ]
    );
  }

  public function showProduct($id)
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
    try
    {
      $product = Product::getProduct($id);
      if (empty($product) /*|| $product -> user_id == Auth::id()*/) {
        $resource = "Product";
        $resourceSmall = "product";
        return view('custom404', ['resource' => $resource, 'resourceSmall' => $resourceSmall]);
      }
      $category = Category::getCategory([['id', $product -> category_id]]);
      $cart = Cart::getCart($id, Auth::id());
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return view('shop/product',
      [
        'product' => $product,
        'category' => $category,
        'cart' => $cart
      ]
    );
  }

  public function addToCart($id)
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
    try
    {
      Cart::addCart(
        [
          'user_id' => Auth::id(),
          'product_id' => $id,
          'quantity' => 1
        ]
      );
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return redirect('/shop/product/'.$id);
  }

  public function removeFromCart($id)
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
    try
    {
      Cart::removeCart([['product_id', (int)$id], ['user_id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('500');
    }
    return redirect('/shop/product/'.$id);
  }

  public function setCartQuantity(Request $request, $id)
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
    try
    {
      $cart = Cart::getCart($id, Auth::id());
      $product = Product::getProduct($id);
    }
    catch(Exception $e)
    {
      return view('500');
    }
    if ($request -> quantity > $product -> quantity)
    {
      Cart::setCart($id, Auth::id(), ['quantity' => $product -> quantity]);
    }
    else if($request -> quantity < 1)
    {
      Cart::setCart($id, Auth::id(), ['quantity' => 1]);
    }
    else {
      Cart::setCart($id, Auth::id(), ['quantity' => $request -> quantity]);
    }
    return redirect('/shop/product/'.$id);
  }

  public function increaseCartQuantity($id)
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
    try
    {
      $cart = Cart::getCart($id, Auth::id());
      Cart::setCart($id, Auth::id(), ['quantity' => ($cart -> quantity + 1)]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/shop/product/'.$id);
  }

  public function decreaseCartQuantity($id)
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
    try
    {
      $cart = Cart::getCart($id, Auth::id());
      Cart::setCart($id, Auth::id(), ['quantity' => ($cart -> quantity - 1)]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/shop/product/'.$id);
  }

  public function setRating(Request $request, $id)
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
    Product::setProduct($id, ['rating' => $request -> rating]);
    return redirect('/shop/product/'.$id);
  }

  public function getProducts(Request $request) {
    if ($request -> has('userName')) {
      $user = User::getUserByName($request -> userName);
      if (!empty($user)) {
        $products = Product::getProducts($user -> id);
        return response() -> json($products, 200);
      }
      else {
        return response() -> json(["message" => "No products exist by this user."], 404);
      }
    }
    if ($request -> has('orderID')) {
      $items = OrderDetail::getOrderDetails($request -> orderID);
      if (!empty($items) and count($items) > 0) {
        $products = [];
        foreach ($items as $item) {
          array_push($products, Product::getProduct($item -> item_id));
        }
        return response() -> json($products, 200);
      }
      else {
        return response() -> json(["message" => "No products exist by this order ID."], 404);
      }
    }
    if ($request -> has('productID')) {
      $product = Product::getProduct($request -> productID);
      if (!empty($product)) {
        return response() -> json($product, 200);
      }
      else {
        return response() -> json(["message" => "No product exists with this ID."], 404);
      }
    }
    $products = Product::getProducts();
    return response() -> json($products, 200);
  }

  public function getProductsWithPagination(Request $request) {
    $currentPage = 1;
    if ($request -> has('page')) {
      $currentPage = (int)$request -> page;
    }
    if ($currentPage < 1)
      return response() -> json(['error' => 'Invalid Page Requested'], 422);
    $products = Product::getProductsCount();
    $totalPages = ceil($products / ($request -> items));
    if ($currentPage <= $totalPages) {
      $products = Product::getProductsWithCustomPagination((($currentPage - 1) * $request -> items), ($request -> items));
      return response() -> json(['currentPage' => $currentPage, 'totalPages' => $totalPages, 'data' => $products], 200);
    }
    else {
      return response() -> json(['error' => 'Invalid Page Requested'], 422);
    }
  }

}
