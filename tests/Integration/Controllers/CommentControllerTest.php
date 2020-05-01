<?php

namespace Tests\Integration\Controllers;

use App\Comments;
use App\Post;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Request;
use tests\Concerns\SeedsSites;
use tests\TestCase;

class CommentControllerTest extends TestCase
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
		$this->get('/comments');
		$this->seeStatusCode(200);
	}

	public function testFindById()
	{
		$post = Comments::inRandomOrder()->first();
		$id = $post->id;

		$data = $this->get('/comments/'. $id);

		$this->seeStatusCode(200);
	}
}


