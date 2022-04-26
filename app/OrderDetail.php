<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class OrderDetail extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['user_id', 'order_id', 'item_id', 'quantity'];
  protected $allAttributes = ['id', 'user_id', 'order_id', 'item_id', 'quantity', 'created_at', 'updated_at', 'deleted_at'];

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
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $orderDetails = $orderDetails -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        throw new Exception();
      }
      $orderDetails = $orderDetails -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $orderDetails;
  }

  public static function getOrderDetail($where = null)
  {
    $orderDetail = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $orderDetail = $orderDetail -> where($where);
    }
    $orderDetail = $orderDetail -> first();
    return $orderDetail;
  }

}
