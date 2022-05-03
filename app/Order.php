<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Order extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['user_id', 'address_line_1', 'address_line_2', 'city', 'state', 'country', 'pin_code', 'total'];
  protected $allAttributes = ['id', 'user_id', 'address_line_1', 'address_line_2', 'city', 'state', 'country', 'pin_code', 'total', 'created_at', 'updated_at', 'deleted_at'];

  public static function addOrder($data) {
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

  public static function getOrders($userId = null, $orderBy = null) {
    $orders = new self;
    if ($userId != null) {
      $orders = $orders -> where('user_id', $userId);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $orders = $orders -> orderBy($orderBy[0], $orderBy[1]);
    }
    if (empty($orders)) {
      return null;
    }
    return $orders -> get();
  }

  public static function getOrder($id = null)
  {
    $order = new self;
    if ($id != null) {
      $order = $order -> where('id', $id);
    }
    if (empty($order)) {
      return null;
    }
    return $order -> first();
  }

}
