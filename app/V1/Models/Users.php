<?php
namespace App\V1\Models;
use App\V1\Models\BaseModel;
/**
 * Model product category
 */
class Users extends BaseModel
{
  /**
   * Table database
   */
  protected $table = 'users';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
       'email', 'password', 'remember_token'
   ];
   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = [
       'password', 'remember_token'
   ];
   protected $validate = [
     'email'=> 'bail|required|email|unique:users',
     'password' => 'required|min:6|confirmed',
   ];

   protected $message = [
     'password.min'     => 'Password minimal 6 karakter',
     'email.unique'     => 'Email tidak tersedia',
     'password.required'=> 'Password harus diisi',
     'email.required'   => 'Email harus diisi',
   ];

   public function validate(){
     return $this->validate;
   }

   public function message(){
     return $this->message;
   }

   public function post(){
    return $this->hasMany('App\V1\Models\Post', 'user_id');
   }
}
