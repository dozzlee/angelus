<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   type="object",
 *   required={"user_id"},
 *   @SWG\Xml(name="Address"),
 *   @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 */
class Address extends Model {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id','phone_number', 'country', 'state', 'zip_code', 'address_line_1', 'address_line_2'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * Unique address identifier
   * @SWG\Property(type="string")
   */
  protected $id;

  /**
   * Phone number related to existing address
   * @SWG\Property(type="string")
   */
  protected $phone_number;

  /**
   * Country related to existing address
   * @SWG\Property(type="string")
   */
  protected $country;

  /**
   * State related to existing address
   * @SWG\Property(type="string")
   */
  protected $state;

  /**
   * Zip code related to existing address
   * @SWG\Property(type="string")
   */
  protected $zip_code;

  /**
   * Address line 1 related to existing address
   * @SWG\Property(type="string")
   */
  protected $address_line_1;

  /**
   * Address line 2 related to existing address
   * @SWG\Property(type="string")
   */
  protected $address_line_2;

  public function user(){
      return $this->belongsTo('App\User');
  }

}
