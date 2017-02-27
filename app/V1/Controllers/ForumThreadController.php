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

class ForumThreadController extends BaseController
{
    use Helpers;
    var $thread;
    public function __construct(){
      $this->thread =  new ForumThread();
    }

    public function index(){

      $thread = $this->thread->all();
      return response($thread);
    }

    public function create(Request $request){
      $user = JWTAuth::parseToken()->authenticate();
      
      $this->thread->fill([
          'thread_name' => $request->input('thread_name'),
          'forum_id' => $request->input('forum_id'),
          'owner_id' => $user->id,
        ]);
      if($this->thread->save()){
        $res['success'] = true;
        $res['result'] = 'Success add thread!';
        return response($res);
      } else {
        $res['success'] = false;
        $res['result'] = 'Failed add thread!';
        return response($res);
      }
    }

    public function show(Request $request, $idForum, $idThread){

      $forum = Forum::find($idForum);
      $thread = ForumThread::find($idThread);
      $post = Post::join('users', 'post.user_id','=','users.id')
      ->select('post.id','post.thread_id','post.post','post.user_id','users.email')->where('thread_id',$thread->id)->orderBy('post.id','desc')->get();
      return response($post);

    }

}
