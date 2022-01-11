<?php

namespace Database\Seeders;

use App\Models\Post;
use Exception;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Post::query()->truncate();
        Post::factory(random_int(10, 20))->create();
    }
}
