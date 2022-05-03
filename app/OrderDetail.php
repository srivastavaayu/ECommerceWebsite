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

  /**
   * It takes an array of data, checks if the data is empty, checks if the data is fillable, and then
   * creates the data
   *
   * @param data The data to be added to the database.
   *
   * @return An instance of the OrderDetail class.
   */
  public static function addOrderDetail($data) {
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

  /**
   * It returns the order details for a given order id
   *
   * @param orderId The order id of the order you want to get the details for.
   *
   * @return An array of objects.
   */
  public static function getOrderDetails($orderId = null)
  {
    $orderDetails = new self;
    if ($orderId != null) {
      $orderDetails = $orderDetails -> where('order_id', $orderId);
    }
    if (empty($orderDetails)) {
      return null;
    }
    return $orderDetails -> get();
  }

}
