<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends Controller
{
    /**
     * Shows all users 
     * @return Response
     */
    public function index() : Response
    {   
        $this->model = 'user';
        $user = $this->all();

        if(!$user) {
            return response()->json(['data' => 'Could not find any Users'], 404);
        }

        return response()->json(['data' => $user], 200);
    }

    /**
     * Adds Users 
     * @param  Request $request 
     * @return Response           
     */
    public function store(Request $request) : Response
    { 
    	$this->validate($request, [
    		'email' => 'required|email|unique:users',
            'name'  => 'required',
            'screen_name' => 'required'
    	]);

        $snowflake = app('Kra8\Snowflake\Snowflake');
        $id = $snowflake->next();

        $user = User::create([
        	'email' => $request->get('email'),
            'name'  => $request->get('name'),
        	'id' 	=> $id,
        	'id_str'       => (string) $id,
            'screen_name'  => $request->get('screen_name')
        ]);

        return response()->json(['data' => 'Successfully added user: '  .  $id, 201]);
    }

    /**
     * Finds user by ID
     * @param  User $id 
     * @return Response     
     */
    public function show($id) : Response  
    {
    	$this->model = 'user';
        $user = $this->find($id, null);

    	if (!$user) {
    		return response()->json(['data' => 'Could not find User :' . $id], 404);
    	}

    	return response()->json(['data' => $user], 200);
    }

    /**
     * Updates details of users
     * @param  Request $request 
     * @param  User  $id      
     * @return Response           
     */
    public function update(Request $request, $id) : Response
    {
        // TODO: Need to use ID_STR Instead
    	$user = User::find($id);

    	if (!$user) {
    		return response()->json(['data' => 'Could not find User'], 404);
    	}

    	$this->validate($request, [
    		'email' => 'required|email|unique:users'
    	]);

    	if ($request->get('name')) {
    		$user->name = $request->get('name');
    	}
   
    	$user->email 	= $request->get('email');

    	$user->save();

    	return response()->json(['data' => 'Successfully Updated User Info'], 200);
    }

    /**
     * Deletes Users
     * @param  Request $request 
     * @param  User  $id      
     * @return Response           
     */
    public function delete($id) : Response
    {
    	$user = User::find($id);

    	if (!$user) {
    		return response()->json(['data' => 'Could not find User'], 404);
    	}

    	$user->delete();

    	return response()->json(['data' => 'Successfully Deleted Account'], 200);
    }
}
