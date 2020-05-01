<?php

namespace Tests\Integration\Controllers;

use App\User;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Request;
use tests\Concerns\SeedsSites;
use tests\TestCase;

class UserControllerTest extends TestCase
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
		$this->get('/users');
		$this->seeStatusCode(200);
	}


	public function testAdd()
	{	
		$user = factory(User::class)->make()->toArray();

        $this->json('POST', '/users', $user)
            ->seeJson([
            	0 => 201,
        ]);
	}

	public function testFindById()
	{
		$user = User::inRandomOrder()->first();
		$id = $user->id;

		$data =$this->get('/users/'. $id);

		$this->seeStatusCode(200);
	}

	public function testUpdate()
	{	
		$user = User::inRandomOrder()->first();
		$id = $user->id;

		$data = [
			'name'  => 'test',
			'screen_name' => 'testblab',
			'email' => 'test@test.com'
		];

        $this->put('/users/' . $id, $data, []);
        
        $this->seeStatusCode(200);
	}

	
	public function testDelete()
	{	
		$user = User::inRandomOrder()->first();
		$id = $user->id;

		$this->delete('/users/' . $id);

		$this->seeStatusCode(200);
	}
}


