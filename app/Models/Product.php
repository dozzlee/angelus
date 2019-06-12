<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   type="object",
 *   required={"name","description", "price", "imageurl", "file_id"},
 *   @SWG\Xml(name="Product"),
 *   @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 */
class Product extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'description', 'price', 'imageurl', 'file_id'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * Unique product identifier
   * @SWG\Property(type="string")
   */
  protected $id;

  /**
   * Product name
   * @SWG\Property(type="string")
   */
  protected $name;

  /**
   * Product description
   * @SWG\Property(type="string")
   */
  protected $description;

  /**
   * Product price
   * @SWG\Property(type="string")
   */
  protected $price;

  /**
   * Product image url
   * @SWG\Property(type="string")
   */
  protected $imageurl;

  /**
   * Product file_id
   * @SWG\Property(type="string")
   */
  protected $file_id;

  public function file() {
     return $this->belongsTo('App\Models\File');
  }
}
