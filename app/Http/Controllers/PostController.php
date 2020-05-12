<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tweets\Entity;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Media;
use App\Tweets\Entity\Polls;
use App\Tweets\Entity\Symbol;
use App\Tweets\Entity\Urls;
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

        $post->each(function ($item, $key) {
            $item->getResponse();
        });

        return response()->json($post, 200);
    }

    /**
     * adds post
     * @param  Request $request
     * @return Response Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'title' => 'required',
                'content' => 'required'
            ]
        );
 
        $snowflake = app('Kra8\Snowflake\Snowflake');
        
        $id = $snowflake->next();

        // For NOW SET USER AS RANDOM
        $userID = $this->getUserID();

        $post = Post::create([
            'id'        => $id,
            'id_str'    => (string) $id,
            'title'     => $request->get('title'),
            'content'   => $request->get('content'),
            'user_id'    => $userID
        ]);

        $entity = Entity::create([
            'post_id' => $post->id
        ]);

        if ($request->hashtag) {
            $this->storeHashTags($request, $entity->id);
        }
      
        if ($request->urls) {
            $this->storeUrls($request, $entity->id);
        }    

        if ($request->media) {
            $this->storeMedia($request, $entity->id);
        }

        if ($request->symbol) {
            $this->storeSymbol($request, $entity->id);
        }

        if ($request->polls) {
            $this->storePolls($request, $entity->id);
        }

        return response()->json(['data' => 'Successfully added Post: '  .  $id, 201]);
    }

    public function storeHashTags(Request $request, Int $entityID) 
    {
        $validation = [
            'hashtag.indices' => 'required',
            'hashtag.text' => 'required'
        ];

        $this->validate($request, $validation);

        $hashtags = HashTags::create([
            'text' => $request->hashtag['text'],
            'indices'  =>  $request->hashtag['indices'],
            'entity_id'  =>  $entityID,
        ]);  
    }

    public function storeUrls(Request $request, Int $entityID)
    {
        $validation = [
            'urls.indices' => 'required',
            'urls.url' => 'required',
            'urls.expanded_url' => 'required',
            'urls.display_url' => 'required',
            'urls.unwound' => 'required',
        ];

        $this->validate($request, $validation);

        $url = Urls::create([
            'url' => $request->urls['url'],
            'expanded_url' => $request->urls['expanded_url'],
            'display_url' => $request->urls['display_url'],
            'unwound' => $request->urls['unwound'],
            'indices' => $request->urls['indices'],
            'entity_id' => $entityID,
        ]);
    }

    public function storeMedia(Request $request, Int $entityID) 
    {
        $validation = [
            'media.indices' => 'required',
            'media.display_url' => 'required',
            'media.media_url' => 'required',
            'media.media_url_https' => 'required',
            'media.expanded_url' => 'required',
            'media.sizes' => 'required',
            'media.type' => 'required',
            'media.url' => 'required'
        ];

        $this->validate($request, $validation);

        $snowflake = app('Kra8\Snowflake\Snowflake');
        $id = $snowflake->next();

        $media = Media::create([
            'id' => $id,
            'id_str' => (string)$id,
            'display_url' => $request->media['display_url'],
            'indices' => $request->media['indices'],
            'media_url' => $request->media['media_url'],
            'media_url_https' => $request->media['media_url_https'],
            'expanded_url' => $request->media['expanded_url'],
            'sizes' => $request->media['sizes'],
            'url' => $request->media['url'],
            'type' => $request->media['type'],
            'entity_id' => $entityID,
        ]);
    }

    public function storeSymbol(Request $request, Int $entityID) 
    {
        $validation = [
            'symbol.indices' => 'required',
            'symbol.text' => 'required',
        ];        

        $this->validate($request, $validation);

        $symbol = Symbol::create([
            'text' => $request->symbol['indices'],
            'indices' => $request->symbol['indices'],
            'entity_id' => $entityID
        ]);
    }

    public function storePolls(Request $request, Int $entityID) 
    {
        $validation = [
            'polls.options' => 'required',
            'polls.end_datetime' => 'required',
            'polls.duration_minutes' => 'required',
        ];        

        $this->validate($request, $validation);

        $poll = Polls::create([
            'options' => $request->polls['options'],
            'end_datetime' => $request->polls['end_datetime'],
            'duration_minutes' => $request->polls['duration_minutes'],
            'entity_id' => $entityID
        ]);        
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

        $result = $post->getResponse();
        
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
