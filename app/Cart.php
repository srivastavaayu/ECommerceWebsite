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

  public static function getCarts($where = null, $groupBy = null, $having = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $carts = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $carts = $carts -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $carts = $carts -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $carts = $carts -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $carts = $carts -> orderBy($orderBy[0], $orderBy[1]);
    }
    if ($paginateRequired) {
      return $carts -> simplePaginate($paginateItems);
    }
    else {
      return $carts -> get();
    }
  }

  public static function getCart($where = null)
  {
    $cart = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $cart = $cart -> where($where);
    }
    $cart = $cart -> first();
    if (empty($cart)) {
      return null;
    }
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
    return null;
  }

}
