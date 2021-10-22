<?php

namespace Database\Seeders;

use App\Models\News;
use Exception;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        News::query()->delete();
        News::factory(random_int(20, 30))->create();
    }
}
