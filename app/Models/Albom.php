<?php namespace App\Models;

 /**
 * This is the Albom model. 
 * It allow us to interact with the 'alboms' table 
 * 
 * @package Models
 * @author Den
 */
use Illuminate\Database\Eloquent\Model;

class Albom extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'alboms';

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
   * Defines the belongsToMany/belongsToMany (many to many) relationship between Albom and Category models
   *
   * @return mixed
   */
  public function categories() {
    return $this->belongsToMany('App\Models\Category', 'alboms_categories', 'albom_id', 'category_id');
  } 
  
  /**
   * Defines the hasMany/belongsTo (one to many) relationship between Albom and Image models
   *
   * @return mixed
   */
  public function images() {
    return $this->hasMany('App\Models\Image');
  }
 
}
