<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['user_id', 'address_line_1', 'address_line_2', 'city', 'state', 'country', 'pin_code', 'total'];

  public static function addOrder($data) {
    if (empty($data)) {
      throw new Exception("Order cannot be created!");
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        throw new Exception("Order cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function getOrders($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $orders = new self;
    if ($where != null) {
      foreach ($where as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orders = $orders -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orders = $orders -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orders = $orders -> having($having);
    }
    if ($orderBy != null) {
      foreach ($orderBy as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orders = $orders -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $orders;
  }

  public static function getOrder($where = null)
  {
    $order = new self;
    if ($where != null) {
      foreach ($where as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $order = $order -> where($where);
    }
    $order = $order -> first();
    return $order;
  }

}
