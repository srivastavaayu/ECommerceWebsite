<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Cart extends Model {

  protected $fillable = ['user_id', 'product_id', 'quantity'];
  protected $allAttributes = ['id', 'user_id', 'product_id', 'quantity', 'created_at', 'updated_at'];


  /**
   * It takes an array of data, checks if the data is empty, checks if the data is fillable, and then
   * creates the data
   *
   * @param data The data to be added to the database.
   *
   * @return A new instance of the Cart model.
   */
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

  /**
   * It removes a cart by its ID.
   *
   * @param id The id of the cart you want to remove.
   *
   * @return The cart is being returned.
   */
  public static function removeCartByID($id) {
    $cart = self::where('id', $id) -> first();
    if (empty($cart)) {
      return null;
    }
    return $cart -> delete();
  }

  /**
   * It removes a cart by product and user info.
   *
   * @param productId The product ID of the product you want to delete from the cart.
   * @param userId The user's id
   *
   * @return The cart is being returned.
   */
  public static function removeCartByProductAndUserInfo($productId, $userId) {
    $cart = self::where([['product_id', $productId], ['user_id', $userId]]) -> first();
    if (empty($cart)) {
      return null;
    }
    return $cart -> delete();
  }

  /**
   * It returns all the carts of a user.
   *
   * @param userId The user id of the user whose cart you want to get. If you don't pass this
   * parameter, it will return all the carts.
   *
   * @return An array of all the carts in the database.
   */
  public static function getCarts($userId = null) {
    $carts = new self;
    if ($userId != null) {
      $carts = $carts -> where('user_id', $userId);
    }
    if (empty($carts)) {
      return null;
    }
    return $carts -> get();
  }

  /**
   * It returns the cart of a user.
   *
   * @param productId The product id of the product you want to add to the cart.
   * @param userId The user id of the user who is adding the product to the cart.
   *
   * @return The first cart item that matches the productId and userId.
   */
  public static function getCart($productId = null, $userId = null)
  {
    $cart = new self;
    if ($productId != null) {
      $cart = $cart -> where('product_id', $productId);
    }
    if ($userId != null) {
      $cart = $cart -> where('user_id', $userId);
    }
    $cart = $cart -> first();
    if (empty($cart)) {
      return null;
    }
    return $cart;
  }

  /**
   * It updates the cart.
   *
   * @param productId The id of the product you want to add to the cart.
   * @param userId The user's id
   * @param data an array of attributes to be updated
   *
   * @return The cart is being returned.
   */
  public static function setCart($productId, $userId, $data)
  {
    $cart = self::where([['product_id', $productId], ['user_id', $userId]]) -> first();
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
