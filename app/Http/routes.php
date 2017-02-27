<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = app('Dingo\Api\Routing\Router');

$params = [
    'version' => 'v1',
    //'prefix' => 'api',
    'namespace' => 'App\V1\Controllers',
];

$middleware = [
    'middleware' => 'auth:api',
    'version' => 'v1',
    'namespace' => 'App\V1\Controllers',
];

//Auth Controller
$api->group($params, function($api)
{
  $api->post('/login', 'AuthController@login');
  //User register
  $api->post('/register', 'UserController@create');
  //Forum
  $api->get('/forum', 'ForumController@index');
  $api->get('/forum/{id}/thread', 'ForumController@show');
  $api->get('/thread', 'ForumThreadController@index');
  $api->get('/forum/{idForum}/thread/{idThread}', 'ForumThreadController@show');
});

//Route with auth
$api->group($middleware, function($api){
  //Forum
  $api->post('/forum', 'ForumController@create');  
  //Thread
  $api->post('/thread', 'ForumThreadController@create');
  //Post
  $api->post('/post', 'PostController@create');
});
