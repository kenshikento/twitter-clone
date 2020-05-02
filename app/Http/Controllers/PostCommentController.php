<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostCommentController extends Controller
{
    /**
     * Just shows all post that have comments
     * @param  int $id should really be ideally bigInteger
     * @return Response Symfony\Component\HttpFoundation\Response;
     */
    public function index($id)  
    { 
        $this->model = 'post';
        $post = $this->find($id, null);

        $comments = $post->comments;
        
        if (!$post) {
            return response()->json(['data' => 'Could not find User [{$id}]'], 404);
        }
        
        return response()->json(['data' => $post], 200);
    }

    /**
     * Store request data for postcomment
     * @param  Request $request 
     * @param  POST  $id  
     * @return Response  Symfony\Component\HttpFoundation\Response;
    */
    public function store(Request $request, $id) : Response
    {
        $post = Post::find($id);

        if (!$post){
            return response()->json(['data' => "The post with {$id} doesn't exist"], 404);
        }

        $this->validate($request, [
            'title' => 'required',
            'content'  => 'required'
        ]);

        // For NOW SET USER AS RANDOM
        $userID = $this->getUserID();
        //'user_id'=> $this->getUserId(),

        $comment = Comments::create([
                'title'     => $request->get('title'),
                'content'   => $request->get('content'),
                'user_id'   => $userID,
                'post_id'   => $id
            ]);

        return response()->json(['data' => 'Successfully added Post with id : '  .  $id, 201]);
    }

    /**
     * Updatess for Post Comment 
     * @param  Request $request   
     * @param  Post  $id        
     * @param  Comment  $commentID
     * @return Response Symfony\Component\HttpFoundation\Response;            
     */
    public function update(Request $request, $id, $commentID)
    {
        $comment    = Comments::find($commentID);
        $post       = Post::find($id);
        
        if (!$comment || !$post) {
            return response()->json(['data' => "The comment with {$commentID} or the post with id {$id} doesn't exist"], 404);
        }

        $this->validate($request, [
            'content'  => 'required'
        ]);

        $comment->content       = $request->get('content');
        $comment->user_id       = $this->getUserID();
        $comment->post_id       = $id;

        $comment->save();

        return response()->json(['The comment with with id {$comment->id} has been updated', 200]);
    }

    /**
     * Deletes given Comment and Post relationship
     * @param  Post $id       
     * @param  Comments $commentID
     * @return Response Symfony\Component\HttpFoundation\Response
     */
    public function delete($id, $commentID)
    {
        $comment    = Comments::find($commentID);
        $post       = Post::find($id);

        if(!$comment || !$post){
            return response()->json(['data' => "The comment with {$commentID} or the post with id {$id} doesn't exist"], 404);
        }

        if(!$post->comments()->find($commentID)){
            return response()->json(['data' => "The comment with id {$commentID} isn't assigned to the post with id {$id}", 409]);
        }

        $comment->delete();

        return response()->json(["The comment with id {$commentID} has been removed of the post {$id}", 200]);
    }
}
