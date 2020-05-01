<?php

use App\Comments;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;
use tests\Concerns\SeedsSites;

class DatabaseSeeder extends Seeder
{
	use SeedsSites;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $this->command->getOutput()->writeln('<info>Seeding:</info> Users');
        User::truncate();
        $this->user();

        $this->command->getOutput()->writeln('<info>Seeding:</info> Main Site');
        Post::truncate();
        Comments::truncate();
        $this->mainData();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
