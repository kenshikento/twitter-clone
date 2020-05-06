<?php

namespace tests\Concerns;

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
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;

trait SeedsSites
{
    public function user()
    {   
        $snowflake = app('Kra8\Snowflake\Snowflake');
        $id1 = $snowflake->next();
        $id2 = $snowflake->next();
        $id3 = $snowflake->next();
        $id4 = $snowflake->next();
        
        factory(User::class)->create(['id' => $id1, 'id_str' => (string) $id1]);
        factory(User::class)->create(['id' => $id2, 'id_str' => (string) $id2]);
        factory(User::class)->create(['id' => $id3, 'id_str' => (string) $id3]);
        factory(User::class)->create(['id' => $id4, 'id_str' => (string) $id4]);

        return $this;
    }

    public function mainData()
    {
        $faker = app(Generator::class);

        $id  = $faker->unique()->randomDigit;
        $id2 = $faker->unique()->randomDigit;
        $id3 = $faker->unique()->randomDigit;

        $userList = User::inRandomOrder()->limit(3)->get();
        // Need to redo array below kinda waste
        $userIDs = [
            1 => ['user_id' => $userList[0], 'id' => 1, 'id_str' => (string)1],
            2 => ['user_id' => $userList[1], 'id' => 2, 'id_str' => (string)2],
            3 => ['user_id' => $userList[2], 'id' => 3, 'id_str' => (string)3]
        ];

        foreach ($userIDs as $key => $value) {
            $posts = factory(Post::class)->create($value);

            $entity = factory(Entity::class)->create(['post_id' => $posts->id]);
            factory(HashTags::class)->create(['entity_id' => $entity->id]);
            factory(Urls::class,5)->create(['entity_id' => $entity->id]);
            $this->command->getOutput()->writeln('<info>Seeding:</info> Main Site');

            $user = User::inRandomOrder()->where('id', '!=', $value['id'])->first();

            factory(UserMention::class,2)->create([
                'entity_id' => $entity->id,
                'user_id' => $user->id
            ]);

            factory(Media::class,2)->create([
                'entity_id' => $entity->id,
            ]);

            factory(Symbol::class,2)->create([
                'entity_id' => $entity->id,
            ]);

            factory(Polls::class)->create([
                'entity_id' => $entity->id,
            ]);            
        }

        factory(Comments::class,10)->create();
    }


}
/*
'id', 'entity_id', 'id_str', 
 */