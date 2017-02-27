<?php
namespace App\V1\Controllers;

use App\V1\Transformers\ForumTransformer;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use App\V1\Models\ForumThread;
use App\V1\Models\Forum;
use App\V1\Models\Post;

class PostController extends BaseController
{
    use Helpers;
    var $post;
    public function __construct(){
      $this->post =  new Post();
    }

    public function index(){

      $post = $this->post->all();
      return response($post);
    }

    public function create(Request $request){
      $user = JWTAuth::parseToken()->authenticate();
      
      $this->post->fill([
          'post' => $request->input('post'),
          'thread_id' => $request->input('thread_id'),
          'user_id' => $user->id,
        ]);
      if($this->post->save()){
        $res['success'] = true;
        $res['result'] = 'Success add post!';
        return response($res);
      } else {
        $res['success'] = false;
        $res['result'] = 'Failed add post!';
        return response($res);
      }
    }
}
