<?php
namespace App\V1\Models;
use App\V1\Models\BaseModel;
/**
 * Model Auction Discussion
 */
class Forum extends BaseModel
{
  /**
   * Table database
   */
  protected $table = 'forum';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id','forum_name','parent'
  ];

  protected $validate = [
    'forum_name' => 'required',
    'parent' => 'numeric|required',
  ];

  protected $message = [
    
  ];

  public function validate(){
    return $this->validate;
  }

  public function message(){
    return $this->message;
  }

  public function forum_thread(){
    return $this->hasMany('App\V1\Models\ForumThread', 'forum_id');
  }
}
