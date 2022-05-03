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

  /**
   * It takes an array of data, checks if the data is empty, checks if the data is fillable, and then
   * creates the data
   *
   * @param data The data to be added to the database.
   *
   * @return An instance of the Order model.
   */
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

  /**
   * It returns all orders for a given user, ordered by a given attribute.
   *
   * @param userId The user id of the user you want to get the orders for.
   * @param orderBy an array of two elements, the first being the column to order by, and the second
   * being the order (asc or desc)
   *
   * @return An array of orders.
   */
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

  /**
   * It returns the order with the given id.
   *
   * @param id The id of the order you want to get.
   *
   * @return The first order in the database.
   */
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
