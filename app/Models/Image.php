<?php namespace App\Models;

 /**
 * This is the Image model. 
 * It allow us to interact with the 'images' table 
 * 
 * @package Models
 * @author Den
 */
use Illuminate\Database\Eloquent\Model;

class Image extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'images';

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
 
 /**
   * Defines the belongsTo/hasMany (one to many) relationship between Image and Albom models
   *
   * @return mixed
   */
  public function albom() {
    return $this->belongsTo('App\Models\Albom');
  }  
 
}

