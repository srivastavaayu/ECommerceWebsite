<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Cart extends Model {

  protected $fillable = ['user_id', 'product_id', 'quantity'];
  protected $allAttributes = ['id', 'user_id', 'product_id', 'quantity', 'created_at', 'updated_at'];


  public static function addCart($data) {
    if (empty($data)) {
      return null;
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        return null;
      }
    }
    return self::create($data);
  }

  public static function removeCart($where) {
    echo var_dump($where);
    foreach ($where as $eachWhere) {
      if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
        return null;
      }
    }
    $cart = self::where($where) -> first();
    echo $cart;
    if (empty($cart)) {
      return null;
    }
    return $cart -> delete();
  }

  public static function getCarts($userId = null) {
    $carts = new self;
    if ($userId != null) {
      $carts = $carts -> where('user_id', $userId);
    }
    if (empty($carts)) {
      return null;
    }
    return $carts -> get();
  }

  public static function getCart($productId = null, $userId = null)
  {
    $cart = new self;
    if ($productId != null) {
      $cart = $cart -> where('product_id', $productId);
    }
    if ($userId != null) {
      $cart = $cart -> where('user_id', $userId);
    }
    $cart = $cart -> first();
    if (empty($cart)) {
      return null;
    }
    return $cart;
  }

  public static function setCart($productId, $userId, $data)
  {
    $cart = self::where([['product_id', $productId], ['user_id', $userId]]) -> first();
    if (!empty($cart)) {
      foreach ($data as $attr => $val) {
        if (in_array($attr, (new self) -> fillable)) {
          $cart[$attr] = $val;
        }
      }
      return $cart -> save();
    }
    return null;
  }

}
