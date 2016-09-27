<?php namespace App\Models;

 /**
 * This is the Vkparser model. 
 * It allow us to interact with the 'vkparsers' table 
 * 
 * @package Models
 * @author Den
 */
use Illuminate\Database\Eloquent\Model;

class Vkparser extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vkparsers';

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

