<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Shows all Post
     * @return Response Symfony\Component\HttpFoundation\Response
     */
    public function index() : Response
    {
        $this->model = 'post';
        $post = $this->all();

        if (!$post) {
            return response()->json(['data' => 'Could not find any posts'], 404);
        }

        return response()->json($post, 200);
    }

    /**
     * adds post
     * @param  Request $request
     * @return Response Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content'  => 'required'
        ]);

        $snowflake = app('Kra8\Snowflake\Snowflake');
        
        $id = $snowflake->next();

        // For NOW SET USER AS RANDOM
        $userID = $this->getUserID();

        $user = Post::create([
            'id'        => $id,
            'id_str'    => (string) $id,
            'title'     => $request->get('title'),
            'content'   => $request->get('content'),
            'user_id'    => $userID
        ]);

        return response()->json(['data' => 'Successfully added Post: '  .  $id, 201]);
    }

    /**
     * Finds value input with based by what model is called
     * @param  bigInteger $id
     * @return use Symfony\Component\HttpFoundation\Response;
     */
    public function show($id) : Response
    {
        $this->model = 'post';
        $post = $this->find($id, null);

        if (!$post) {
            return response()->json(['Could not find any post'], 404);
        }

        if (!$post->user()->first()) {
            return response()->json(['Error has occured please try again'], 500);
        }

        $result = $post->getJsonResponse();
        
        return response()->json($result, 200);
    }

    /**
     * Update method for Post Controller
     * @param  Request $request
     * @param  Post  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['data' => 'Could not find post'], 404);
        }

        $this->validate($request, [
            'title'   => 'required',
            'content' => 'required'
        ]);

        $post->title = $request->get('title');
        $post->content = $request->get('content');

        $post->save();

        return response()->json(['data' => 'Successfully Updated User Info'], 200);
    }

    /**
     * Delete Method For Post
     * @param  Post $id
     * @return Response
     */
    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['data' => 'Could not find post'], 404);
        }

        $post->delete();

        return response()->json(['data' => 'Successfully Deleted Account'], 200);
    }
}
