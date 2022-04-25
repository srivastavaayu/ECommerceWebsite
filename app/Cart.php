<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

  protected $fillable = ['user_id', 'product_id', 'quantity'];

  public static function addCart($data)
  {
    if (empty($data)) {
      throw new Exception("Cart element cannot be created!");
    }
    foreach ($data as $attr => $val)
    {
      if (!in_array($attr, (new self) -> fillable))
      {
        throw new Exception("Cart element cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function removeCart($where)
  {
    $cart = self::where($where) -> firstOr(function()
      {
        return null;
      }
    );
    return $cart -> delete();
  }

  public static function getCarts($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $carts = new self;
    if ($where != null)
    {
      $carts = $carts -> where($where);
    }
    if ($groupBy != null)
    {
      $carts = $carts -> groupBy($groupBy);
    }
    if ($having != null)
    {
      $carts = $carts -> having($having);
    }
    if ($orderBy != null)
    {
      $carts = $carts -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $carts;
  }

  public static function getCart($where = null)
  {
    $cart = new self;
    if ($where != null)
    {
      $cart = $cart -> where($where);
    }
    $cart = $cart -> first();
    return $cart;
  }

  public static function setCart($where, $data)
  {
    $cart = self::where($where) -> first();
    if (!empty($null))
    {
      foreach ($data as $attr => $val)
      {
        if (in_array($attr, (new self) -> fillable))
        {
          $cart[$attr] = $val;
        }
      }
      return $cart -> save();
    }
  }

}
