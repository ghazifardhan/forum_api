<?php

namespace App\V1\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Dingo\Api\Routing\Helpers;
use App\V1\Models\Users as User;

class AuthController extends BaseController
{
    use Helpers;
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        try {
            if (! $token = $this->jwt->attempt($credentials)) {
                return response()->json(['Maaf Anda tidak bisa login'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
    }

    public function login_third(Request $request){
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);
        //Check is the email have registered
        if (User::where('email', '=',  $request->input('email'))->exists()) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'confirm' => 1
            ];
        } else {
            //Create the user first
            $user = array(
                'email'=> $request->input('email'),
                'name'=>$request->input('name'),
                'password'=> $request->input('password'),
                'password_confirmation' => $request->input('password'),
            );
            $response = $this->api->post('register',$user);
            //If success create user, create credentials
            if($response['success']){
                $credentials = [
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'confirm' => 1
                ];
            }
        }

        if (! $token = $this->jwt->attempt($credentials)) {
            var_dump($token);
            //return response()->json(['Maaf Anda tidak bisa login'], 404);
        }
        return response()->json(compact('token'));
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $token = \JWTAuth::getToken();

        \JWTAuth::invalidate($token);

        return response()->json(['logout' => 'Logout'],200);
    }
}
?>
