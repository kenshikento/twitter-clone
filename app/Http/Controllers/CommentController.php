<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Shows all comments 
     * @return Response Should return json response 
     */
	public function index() : Response
    { 
        $this->model = 'comment';
        $comment = $this->all();

        if($comment[0] === 404) {
            return response()->json(['data' => $comment], 404);
        }

		return response()->json(['data' => $comment], 200);
    }

    /**
     * Should show comments filtered by ID
     * @param  int $id
     * @return Response json 
     */
	public function show($id) : Response
    {
        $this->model = 'comment';
        $comment = $this->find($id, null);

        if ($comment[0] === 404) {
            return response()->json(['data' => 'Could not find any comment with {$id}'], 404);
        }
        
        return response()->json(['data' => $comment], 200);
    }
}
