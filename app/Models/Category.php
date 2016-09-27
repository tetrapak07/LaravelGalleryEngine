<?php namespace App\Models;

 /**
 * This is the Category model. 
 * It allow us to interact with the 'categories' table 
 * 
 * @package Models
 * @author Den
 */
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'categories';

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
   * Defines the belongsToMany/belongsToMany (many to many) relationship between Category and Albom models
   *
   * @return mixed
   */
  public function alboms() {
    return $this->belongsToMany('App\Models\Albom', 'alboms_categories',  'category_id', 'albom_id');
  } 
  
  /**
   * Defines the belongsTo/hasOne (one to one) relationship between Page and Category models
   *
   * @return mixed
   */
  public function page() {
    return $this->hasOne('App\Models\Page');
  }
 
}


