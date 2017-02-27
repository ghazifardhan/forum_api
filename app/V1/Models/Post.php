<?php
namespace App\V1\Models;
use App\V1\Models\BaseModel;
/**
 * Model Auction Discussion
 */
class Post extends BaseModel
{
  /**
   * Table database
   */
  protected $table = 'post';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id','thread_id','post','user_id'
  ];

  protected $validate = [
    'thread_id' => 'numeric|equired',
    'post' => 'required',
  ];

  protected $message = [
    
  ];

  public function validate(){
    return $this->validate;
  }

  public function message(){
    return $this->message;
  }

  public function users(){
    return $this->hasOne('App\V1\Models\Users');
  }
}
