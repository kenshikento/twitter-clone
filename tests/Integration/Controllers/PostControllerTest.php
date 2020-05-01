<?php

namespace Tests\Integration\Controllers;

use App\Post;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Request;
use tests\Concerns\SeedsSites;
use tests\TestCase;

class PostControllerTest extends TestCase
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
		$this->get('/posts');
		$this->seeStatusCode(200);
	}

	public function testAdd()
	{	
		$post = factory(Post::class)->make()->toArray();
		
        $this->json('POST', '/posts', $post)
            ->seeJson([
            	0 => 201,
        ]);
	}

	public function testFindById()
	{
		$post = Post::inRandomOrder()->first();
		$id = $post->id;

		$data = $this->get('/posts/'. $id);

		$this->seeStatusCode(200);
	}

	public function testUpdate()
	{	
		$post = Post::inRandomOrder()->first();
		$id = $post->id;

		$data = [
			'title'  => 'test',
			'content' => 'test@test.com'
		];

        $this->put('/posts/' . $id, $data, []);
        
        $this->seeStatusCode(200);
	}

	
	public function testDelete()
	{	
		$post = Post::inRandomOrder()->first();
		$id = $post->id;

		$this->delete('/posts/' . $id);

		$this->seeStatusCode(200);
	}
}


