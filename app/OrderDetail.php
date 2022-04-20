<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['user_id', 'order_id', 'item_id', 'quantity'];

  public static function addOrderDetail($data)
  {
    OrderDetail::create($data);
  }

  public static function getOrderDetails($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $orderDetails = new OrderDetail;
    if ($where != null)
    {
      $orderDetails = $orderDetails -> where($where);
    }
    if ($groupBy != null)
    {
      $orderDetails = $orderDetails -> groupBy($groupBy);
    }
    if ($having != null)
    {
      $orderDetails = $orderDetails -> having($having);
    }
    if ($orderBy != null)
    {
      $orderDetails = $orderDetails -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $orderDetails;
  }

  public static function getOrderDetail($where = null)
  {
    $orderDetail = new OrderDetail;
    if ($where != null)
    {
      $orderDetail = $orderDetail -> where($where);
    }
    $orderDetail = $orderDetail -> first();
    return $orderDetail;
  }

}
