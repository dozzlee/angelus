<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   type="object",
 *   required={"user_id"},
 *   @SWG\Xml(name="Cart"),
 *   @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 */
class Cart extends Model {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * Unique cart identifier
   * @SWG\Property(type="string")
   */
  protected $id;

  /**
   * User_id related to existing cart
   * @SWG\Property(type="string")
   */
  protected $user_id;

  public function user(){
      return $this->belongsTo('App\User');
  }

  public function cartItems(){
      return $this->hasMany('App\Models\CartItem');
  }

}
