<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   type="object",
 *   required={"user_id","total_paid", "stripe_transaction_id"},
 *   @SWG\Xml(name="Order"),
 *   @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 */
class Order extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'total_paid', 'transaction_id'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * Unique order identifier
   * @SWG\Property(type="string")
   */
  protected $id;

  /**
   * User_id related to existing order
   * @SWG\Property(type="string")
   */
  protected $user_id;

  /**
   * Total amount paid for order
   * @SWG\Property(type="string")
   */
  protected $total_paid;

  /**
   * Transaction id related to existing order
   * @SWG\Property(type="string")
   */
  protected $stripe_transaction_id;

  public function user(){
     return $this->belongsTo('App\User');
  }

  public function orderItems(){
     return $this->hasMany('App\Models\OrderItem');
  }
}
