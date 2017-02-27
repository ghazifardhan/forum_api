<?php
namespace App\V1\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\V1\Models\Users as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use JWTAuth;
use MyHelpers;
use Ramsey\Uuid\Uuid;

class UserController extends BaseController {

    public function __construct(){
        $this->user = new User();
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(Request $request, $service = "")
    {
        $this->user->fill([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),//bcrypt($$request->input('password')),
        ]);
        if ($this->user->save()) {
            $res['success'] = true;
            $res['result'] = 'Success Register';
            return response($res);
        }
        else {
            $res['success'] = false;
            $res['result'] = 'Create Failed';
            return response($res);
        }
    }
    
    private function _validate($data, $fields = array())
     {
         $validators = $this->user->validate();
         $messages = $this->user->message();
         if (!empty($fields)) {
             foreach ($fields as $field) {
                 $validator[$field] = $validators[$field];
             }
         } else {
             $validator = $validators;
         }
         $invalid = Validator::make($data, $validator, $messages);

         return $invalid;
     }

}

?>
