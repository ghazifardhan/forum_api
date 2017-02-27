<?php
namespace App\V1\Controllers;

use App\V1\Transformers\ForumTransformer;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use App\V1\Models\Forum;
use App\V1\Models\ForumThread;

class ForumController extends BaseController
{
    use Helpers;
    var $forum;
    public function __construct(){
      $this->forum =  new Forum();
    }

    public function index(){
      $forum = $this->forum->all();
      return response($forum);
    }

    public function create(Request $request){
      $user = JWTAuth::parseToken()->authenticate();
      $this->forum->fill([
          'forum_name' => $request->input('forum_name'),
          'parent' => $request->input('parent'),
        ]);
      if($this->forum->save()){
        $res['success'] = true;
        $res['result'] = 'Success add forum!';
        return response($res);
      } else {
        $res['success'] = false;
        $res['result'] = 'Failed add forum!';
        return response($res);
      }
    }

    public function show(Request $request, $id){
      $user = JWTAuth::parseToken()->authenticate();

      $forum = ForumThread::where('forum_id',$id)->get();
      return response($forum);
    }

}
