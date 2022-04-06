<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['user_id', 'address_line_1', 'address_line_2', 'city', 'state', 'country', 'pin_code', 'total'];

  public static function addOrder($data) {
    $order = Order::create($data);
    return $order;
  }

  public static function getOrders($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $orders = new Order;
    if ($where != null) {
      $orders = $orders -> where($where);
    }
    if ($groupBy != null) {
      $orders = $orders -> groupBy($groupBy);
    }
    if ($having != null) {
      $orders = $orders -> having($having);
    }
    if ($orderBy != null) {
      $orders = $orders -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $orders;
  }

  public static function getOrder($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $order = new Order;
    if ($where != null) {
      $order = $order -> where($where);
    }
    if ($groupBy != null) {
      $order = $order -> groupBy($groupBy);
    }
    if ($having != null) {
      $order = $order -> having($having);
    }
    if ($orderBy != null) {
      $order = $order -> orderBy($orderBy[0], $orderBy[1]);
    }
    $order = $order -> firstOr(function() {
      return null;
    });
    return $order;
  }

}
