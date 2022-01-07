<?php

namespace Database\Seeders;

use App\Models\Comment;
use Exception;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Comment::query()->truncate();
        Comment::factory(random_int(10, 20))->create();
    }
}
