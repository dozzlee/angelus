<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   type="object",
 *   required={"cart_id", "product_id", "quantity"},
 *   @SWG\Xml(name="CartItem"),
 *   @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 */
class CartItem extends Model {

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['cart_id', 'product_id', 'quantity'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * Unique cart item identifier
   * @SWG\Property(type="string")
   */
  protected $id;

  /**
   * Unique cart Id related to existing cart item
   * @SWG\Property(type="string")
   */
  protected $cart_id;

  /**
   * Unique product Id related to existing cart item
   * @SWG\Property(type="string")
   */
  protected $product_id;

  /**
   * Amount of cart item in cart
   * @SWG\Property(type="string")
   */
  protected $quantity;

  public function cart() {
      return $this->belongsTo('App\Models\Cart');
  }

  public function product() {
      return $this->belongsTo('App\Models\Product');
  }
}
