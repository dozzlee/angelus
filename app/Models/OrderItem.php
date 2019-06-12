<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   type="object",
 *   required={"order_id", "product_id", "file_id"},
 *   @SWG\Xml(name="CartItem"),
 *   @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 */
class OrderItem extends Model {

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['order_id', 'product_id', 'file_id'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * Unique order item identifier
   * @SWG\Property(type="string")
   */
  protected $id;

  /**
   * Unique order Id related to existing order item
   * @SWG\Property(type="string")
   */
  protected $order_id;

  /**
   * Unique product Id related to existing order item
   * @SWG\Property(type="string")
   */
  protected $product_id;

  /**
   * Unique file Id related to existing order product_id
   * @SWG\Property(type="string")
   */
  protected $file_id;

  public function file(){
      return $this->belongsTo('App\Models\File');
  }

  public function product() {
      return $this->belongsTo('App\Models\Product');
  }
}
