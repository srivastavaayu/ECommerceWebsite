<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

  protected $fillable = ['user_id', 'product_id', 'quantity'];

  public static function addCart($data) {
    Cart::create($data);
  }

  public static function removeCart($where) {
    $cart = Cart::where($where) -> firstOr(function() {
      return null;
    });
    $cart -> delete();
  }

  public static function getCarts($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $carts = new Cart;
    if ($where != null) {
      $carts = $carts -> where($where);
    }
    if ($groupBy != null) {
      $carts = $carts -> groupBy($groupBy);
    }
    if ($having != null) {
      $carts = $carts -> having($having);
    }
    if ($orderBy != null) {
      $carts = $carts -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $carts;
  }

  public static function getCart($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $cart = new Cart;
    if ($where != null) {
      $cart = $cart -> where($where);
    }
    if ($groupBy != null) {
      $cart = $cart -> groupBy($groupBy);
    }
    if ($having != null) {
      $cart = $cart -> having($having);
    }
    if ($orderBy != null) {
      $cart = $cart -> orderBy($orderBy[0], $orderBy[1]);
    }
    $cart = $cart -> firstOr(function() {
      return null;
    });
    return $cart;
  }

  public static function setCart($where, $data) {
    $cart = Cart::where($where) -> firstOr(function() {
      return null;
    });
    foreach ($data as $dataPoint) {
      $cart[$dataPoint[0]] = $dataPoint[1];
    }
    $cart -> save();
  }

}
