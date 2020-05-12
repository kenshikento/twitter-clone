<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comments;
use App\Post;
use App\Tweets\Entity;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Media;
use App\Tweets\Entity\Polls;
use App\Tweets\Entity\Symbol;
use App\Tweets\Entity\Urls;
use App\Tweets\Entity\UserMention;
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
    $indices  = json_encode($array);
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
        'indices' => $indices
    ];
});

$factory->define(UserMention::class, function (Faker $faker, $entity = null) {
    $array = [1,2];
    $indices  = json_encode($array);

    return [
        'indices' => $indices,
    ];
});


$factory->define(Media::class, function (Faker $faker) {
    
    $snowflake = app('Kra8\Snowflake\Snowflake');        
    $id = $snowflake->next();    

    $sizes = ['sizes' => [
          'thumb'=> [
               'h'=> 150,
               'resize'=> 'crop',
               'w'=> 150
          ],
          'large'=> [
              'h'=> 1366,
              'resize'=> 'fit',
              'w'=> 2048
          ],
          'medium'=> [
              'h'=> 800,
              'resize'=> 'fit',
              'w'=> 1200
          ],
          'small'=> [
              'h'=> 454,
              'resize'=> 'fit',
              'w'=> 680
          ]
      ]];

    $sizes = json_encode($sizes);
    $indices = json_encode([1,2]);

    return [
        'id'    =>  $id,
        'id_str'    => (string)$id,
        'indices' => $indices,
        'display_url' => $faker->url,
        'media_url' => $faker->url,
        'media_url_https' => $faker->url,
        'expanded_url' => $faker->url,
        'sizes' => $sizes,
        'type'  => 'photo',
        'url'   => $faker->url,
    ];
});

$factory->define(Symbol::class, function (Faker $faker) {
    $array = [1,2];
    $indices  = json_encode($array);

    return [
        'indices' => $indices,
        'text'  => $faker->paragraph(1),
    ];
});

$factory->define(Polls::class, function (Faker $faker) {

    $options = [
        "options" => [
                [
                    "position" => 1,
                    "text" => "I read documentation once."
                ]
        ]
    ];

    $options = json_encode($options);

    return [
        'options' => $options,
        'end_datetime'  => $faker->dateTime()->format('Y-m-d H:i:s'),
        'duration_minutes'  => rand(1,60)
    ];
});
