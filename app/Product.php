<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Product extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'units_sold', 'is_archived', 'rating'];
  protected $allAttributes = ['id', 'category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'units_sold', 'is_archived', 'rating', 'created_at', 'updated_at', 'deleted_at'];

  /**
   * It takes an array of data, checks if the data is empty, checks if the data is fillable, and then
   * creates the data
   *
   * @param data The data to be added to the database.
   *
   * @return An instance of the Product model.
   */
  public static function addProduct($data) {
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
   * It returns a collection of products based on the parameters passed to it
   *
   * @param userId The id of the user who created the product.
   * @param categoryId The id of the category you want to get products from.
   * @param isArchived 0 = not archived, 1 = archived
   * @param orderBy An array of two elements, the first element is the column name and the second
   * element is the order (asc or desc).
   * @param paginateRequired If you want to paginate the results, set this to true.
   * @param paginateItems The number of items to be displayed per page.
   *
   * @return A collection of products.
   */
  public static function getProducts($userId = null, $categoryId = null, $isArchived = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $products = new self;
    if ($userId != null) {
      $products = $products -> where('user_id', $userId);
    }
    if ($categoryId != null) {
      $products = $products -> where('category_id', $categoryId);
    }
    if ($isArchived != null) {
      $products = $products -> where('is_archived', $isArchived);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    if (empty($products)) {
      return null;
    }
    if ($paginateRequired) {
      return $products -> simplePaginate($paginateItems);
    }
    else {
      return $products -> get();
    }
  }

  /**
   * It returns a collection of products based on the parameters passed to it
   *
   * @param categoryId The id of the category you want to filter by.
   * @param isArchived If you want to get all the products that are archived, set this to 1. If you
   * want to get all the products that are not archived, set this to 0. If you want to get all the
   * products, set this to null.
   * @param loggedInUserId This is the id of the user who is logged in. This is used to exclude the
   * products of the logged in user from the list of products.
   * @param orderBy This is an array of two elements. The first element is the column name and the
   * second element is the order.
   * @param paginateRequired If you want to paginate the results, set this to true.
   * @param paginateItems The number of items to be displayed per page.
   *
   * @return A collection of products.
   */
  public static function getClientProducts($categoryId = null, $isArchived = null, $loggedInUserId = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $products = new self;
    if ($loggedInUserId != null) {
      $products = $products -> where('user_id', '!=', $loggedInUserId);
    }
    if ($categoryId != null) {
      $products = $products -> where('category_id', $categoryId);
    }
    if ($isArchived != null) {
      $products = $products -> where('is_archived', $isArchived);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    if (empty($products)) {
      return null;
    }
    if ($paginateRequired) {
      return $products -> simplePaginate($paginateItems);
    }
    else {
      return $products -> get();
    }
  }

  /**
   * It returns a collection of products that match the search term, is archived status, and order by
   * parameters
   *
   * @param searchTerm The search term to search for.
   * @param isArchived 0 = not archived, 1 = archived
   * @param orderBy An array of two elements, the first being the column to order by, and the second
   * being the order (asc or desc).
   *
   * @return A collection of products.
   */
  public static function getProductsWithSearch($searchTerm = null, $isArchived = null, $orderBy = null) {
    $products = new self;
    if ($searchTerm != null) {
      $products = $products -> where('name', 'LIKE', '%'.$searchTerm.'%') -> orWhere('description', 'LIKE', '%'.$searchTerm.'%');
    }
    if ($isArchived != null) {
      $products = $products -> where('is_archived', $isArchived);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    if (empty($products)) {
      return null;
    }
    return $products -> get();
  }

  /**
   * Get all products, skip the first  number of products, and take the next  number of
   * products.
   *
   * @param skip The number of records to skip.
   * @param take The number of records to return.
   *
   * @return An array of products.
   */
  public static function getProductsWithCustomPagination($skip = 0, $take = 3) {
    $products = new self;
    return $products -> skip($skip) -> take($take) -> get();
  }

  /**
   * It returns the number of products in the database
   *
   * @return The number of products in the database.
   */
  public static function getProductsCount() {
    $products = new self;
    return $products -> count();

  }

  /**
   * It returns the product with the given id.
   *
   * @param id The id of the product you want to get.
   *
   * @return The first product in the database.
   */
  public static function getProduct($id = null) {
    $product = new self;
    if ($id != null) {
      $product = $product -> where('id', $id);
    }
    if (empty($product)) {
      return null;
    }
    return $product -> first();
  }

  /**
   * It takes an id and an array of data, finds the product with that id, and updates the product with
   * the data
   *
   * @param id The id of the product you want to update.
   * @param data an array of key-value pairs, where the key is the attribute name and the value is the
   * attribute value.
   *
   * @return The product is being returned.
   */
  public static function setProduct($id, $data) {
    $product = Product::where('id', $id) -> first();
    if (!empty($product)) {
      foreach ($data as $attr => $val) {
        if (in_array($attr, (new self) -> fillable)) {
          $product[$attr] = $val;
        }
      }
      return $product -> save();
    }
  }

}
