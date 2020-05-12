<?php

namespace Tests\Integration\Controllers;

use App\Post;
use App\Tweets\Entity;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Media;
use App\Tweets\Entity\Polls;
use App\Tweets\Entity\Symbol;
use App\Tweets\Entity\Urls;
use App\Tweets\Entity\UserMention;
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
	/*
	public function testShow()
	{	
		$this->get('/posts');
		$this->seeStatusCode(200);
	}*/

	public function testAdd()
	{	
		$post = factory(Post::class)->make(['id' => 123]);

		//$entity = factory(Entity::class)->make(['post_id' => $post->id, 'id' => 1, 'id_str' => '1']);
		
		$hashtag = factory(HashTags::class)->make();
		$urls = factory(Urls::class)->make();
		$usermention = factory(UserMention::class)->make();
		$media = factory(Media::class)->make();
		$symbol = factory(Symbol::class)->make();
		$polls = factory(Polls::class)->make();

		$post->hashtag = $hashtag;
		$post->urls = $urls;
		$post->usermention = $usermention;
		$post->media = $media;
		$post->symbol = $symbol;
		$post->polls = $polls;

		$post = $post->toArray();

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


