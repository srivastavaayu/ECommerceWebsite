<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Category extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'description'];
  protected $allAttributes = ['id', 'name', 'description', 'created_at', 'updated_at', 'deleted_at'];


  /**
   * It takes an array of data, checks if the data is empty, checks if the data is valid, and then
   * creates a new category
   *
   * @param data The data to be added to the database.
   *
   * @return A new category is being created.
   */
  public static function addCategory($data) {
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
   * It returns all the categories from the database
   *
   * @param paginateRequired This is a boolean value that determines whether or not you want to
   * paginate the results.
   * @param paginateItems The number of items to be displayed per page.
   *
   * @return The categories table is being returned.
   */
  public static function getCategories($paginateRequired = false, $paginateItems = 3) {
    $categories = new self;
    if ($paginateRequired) {
      return $categories -> simplePaginate($paginateItems);
    }
    else {
      return $categories -> get();
    }
  }

  /**
   * It returns all categories that match the search term, or all categories if no search term is
   * provided
   *
   * @param searchTerm The search term that the user entered.
   *
   * @return An array of categories
   */
  public static function getCategoriesWithSearch($searchTerm = null) {
    $categories = new self;
    if ($searchTerm != null) {
      $categories = $categories -> where('name', 'LIKE', '%'.$searchTerm.'%');
    }
    if (empty($categories)) {
      return null;
    }
    return $categories -> get();
  }

  /**
   * It returns the category with the given id.
   *
   * @param id The id of the category you want to get.
   *
   * @return The first category in the database.
   */
  public static function getCategory($id = null) {
    $category = new self;
    if ($id != null) {
      $category = $category -> where('id', $id);
    }
    if (empty($category)) {
      return null;
    }
    return $category -> first();
  }

}
