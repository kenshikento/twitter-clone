<?php

namespace Tests\Integration\Controllers;

use App\Comments;
use App\Post;
use App\User;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Request;
use tests\Concerns\SeedsSites;
use tests\TestCase;

class PostCommentControllerTest extends TestCase
{
	use DatabaseMigrations, SeedsSites;

	public function setUp() : void
	{
	    parent::setUp();
	    $this->runDatabaseMigrations();
	    $this->artisan('db:seed');

	}

	public function testShow()
	{	
		$id = Post::inRandomOrder()->first()->id;
		$this->get('/posts/' . $id . '/comments');
		$this->seeStatusCode(200);
	}


	public function testAdd()
	{	
		$post = Post::inRandomOrder()->first()->toArray();

        $this->json('POST', '/posts/'.$post['id'].'/comments', $post)
            ->seeJson([
            	0 => 201
        ]);
	}

	public function testUpdate()
	{	
		$post = Post::inRandomOrder()->first();
		$postID = $post->id;

		$id = Comments::inRandomOrder()->first()->id;

		$data = [
			'content' => 'Whatever'
		];

        $this->put('/posts/' . $postID . '/comments/'. $id, $data, []);
        
        $this->seeStatusCode(200);
	}

	
	public function testDelete()
	{	
		$post = Post::inRandomOrder()->first();
		$postID = $post->id;
		$comment = $post->comments()->first();
		$id = $comment->id;
		//$id = Comments::inRandomOrder()->first()->id;

		$this->delete('/posts/' . $postID . '/comments/' . $id);

		$this->seeStatusCode(200);
	}
}
