<?php
namespace App\V1\Models;
use App\V1\Models\BaseModel;
/**
 * Model Auction Discussion
 */
class ForumThread extends BaseModel
{
  /**
   * Table database
   */
  protected $table = 'forum_thread';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id','forum_id','thread_name','owner_id'
  ];

  protected $validate = [
    'forum_id' => 'numeric|equired',
    'thread_name' => 'required',
  ];

  protected $message = [
    
  ];

  public function validate(){
    return $this->validate;
  }

  public function message(){
    return $this->message;
  }

  public function post(){
    return $this->hasMany('App\V1\Models\Post', 'thread_id');
  }
}
