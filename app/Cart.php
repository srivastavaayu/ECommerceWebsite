<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Cart extends Model {

  protected $fillable = ['user_id', 'product_id', 'quantity'];
  protected $allAttributes = ['id', 'user_id', 'product_id', 'quantity', 'created_at', 'updated_at'];


  public static function addCart($data) {
    if (empty($data)) {
      throw new Exception("Cart element cannot be created!");
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        throw new Exception("Cart element cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function removeCart($where) {
    $cart = self::where($where) -> first();
    return $cart -> delete();
  }

  public static function getCarts($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $carts = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $carts = $carts -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $carts = $carts -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $carts = $carts -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        throw new Exception();
      }
      $carts = $carts -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $carts;
  }

  public static function getCart($where = null)
  {
    $cart = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $cart = $cart -> where($where);
    }
    $cart = $cart -> first();
    return $cart;
  }

  public static function setCart($where, $data)
  {
    $cart = self::where($where) -> first();
    if (!empty($cart)) {
      foreach ($data as $attr => $val) {
        if (in_array($attr, (new self) -> fillable)) {
          $cart[$attr] = $val;
        }
      }
      return $cart -> save();
    }
  }

}
