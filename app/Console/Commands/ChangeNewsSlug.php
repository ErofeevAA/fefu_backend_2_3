<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Redirect;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChangeNewsSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change_news_slug {oldSlug} {newSlug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldSlug = $this->argument('oldSlug');
        $newSlug = $this->argument('newSlug');

        if ($oldSlug === $newSlug) {
            $this->error("Old and new slugs are equal");
            return 1;
        }

        $news = News::where('slug', $oldSlug)->first();
        if ($news === null) {
            $this->error("News with this slug does not exist");
            return 1;
        }

        $oldUrl = route('news_item', ['slug' => $oldSlug], false);
        $newUrl = route('news_item', ['slug' => $newSlug], false);

        $redirect = Redirect::where('old_slug',  $oldUrl)
            ->where('new_slug', $newUrl)->first();

        if($redirect !== null) {
            $this->error("This redirect already exists");
            return 1;
        }

        DB::transaction(function () use ($news, $oldSlug, $newSlug, $newUrl) {
            Redirect::where('old_slug',  $newUrl)->delete();
            $news->slug = $newSlug;
            $news->save();
        });

        return 0;
    }
}
