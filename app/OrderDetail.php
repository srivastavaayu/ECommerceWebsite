<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['user_id', 'order_id', 'item_id', 'quantity'];

  public static function addOrderDetail($data) {
    if (empty($data)) {
      throw new Exception("Order Detail cannot be created!");
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        throw new Exception("Order Detail cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function getOrderDetails($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $orderDetails = new self;
    if ($where != null) {
      foreach ($where as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> having($having);
    }
    if ($orderBy != null) {
      foreach ($orderBy as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $orderDetails;
  }

  public static function getOrderDetail($where = null)
  {
    $orderDetail = new self;
    if ($where != null) {
      foreach ($where as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $orderDetail = $orderDetail -> where($where);
    }
    $orderDetail = $orderDetail -> first();
    return $orderDetail;
  }

}
