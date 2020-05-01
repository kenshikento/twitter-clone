<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ControllerFactory
{
    /**
     * Factory that decides what kind of model to use
     * @param  string $modelType 
     * @return Model
     */
	public function make(string $modelType) : Model
	{
        switch ($modelType) {
            case 'post':
                return new Post();
            case 'user':
                return new User();
            case 'comment':
            	return new Comments();
        }

        throw new Exception("Unsupported model type [{$modelType}]");		
	}
}