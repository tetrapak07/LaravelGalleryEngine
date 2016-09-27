<?php namespace App\Models;

 /**
 * This is the Page model. 
 * It allow us to interact with the 'pages' table 
 * 
 * @package Models
 * @author Den
 */
use Illuminate\Database\Eloquent\Model;

class Page extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'pages';

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
   * Defines the belongsTo/hasOne (one to one) relationship between Page and Category models
   *
   * @return mixed
   */
  public function category() {
    return $this->belongsTo('App\Models\Category');
  }  
 
}

