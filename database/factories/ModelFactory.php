<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comments;
use App\Post;
use App\Tweets\Entity;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Urls;
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

$factory->define(Entity::class, function (Faker $faker) {
    return [
        
    ];
});

$factory->define(HashTags::class, function (Faker $faker) {
    $array = [1,2];
    $test  = json_encode($array);

    return [
        'text' => $faker->paragraph(1),
        'indices' => $test
    ];
});

$factory->define(Urls::class, function (Faker $faker) {
    $array = [1,2];
    $test  = json_encode($array);
    $url = $faker->url;       

    $unwound = [
        'url'   => $url,
        'status'    => 200,
        'title' =>  $faker->paragraph(1),
        'desciption' => $faker->paragraph(1)
    ];       

    return [
        'url' => $url,
        'expanded_url' => $url,
        'display_url' => $url,
        'unwound' =>    json_encode($unwound),
        'indices' => $test
    ];
});

/*
            $table->text('url');
            $table->text('expanded_url');
            $table->text('display_url');
            $table->text('unwound');
            $table->text('z');

            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entity');
 */