<?php namespace App\Models;

 /**
 * This is the Vkapp model. 
 * It allow us to interact with the 'vkapps' table 
 * 
 * @package Models
 * @author Den
 */
use Illuminate\Database\Eloquent\Model;

class Vkapp extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vkapps';

  /**
   * The attributes that are mass not assignable.
   *
   * @var array
   */
  protected $guarded = ['id'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

}

