<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comments;
use App\Post;
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'name'  => $faker->name,
        'screen_name'  => $faker->name
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
    	'title' 	=> $faker->sentence(1),
        'content' 	=> $faker->paragraph(1),
    ];
});

$factory->define(Comments::class, function (Faker $faker) {
    $postList = Post::inRandomOrder()->get();
    $randUser = User::inRandomOrder()->first();
    $countList = count($postList);
    
    return [
        'content' => $faker->paragraph(1),
        'post_id' => $postList[mt_rand(1,$countList - 1)]->id,
        'user_id' => $randUser->id
    ];
});