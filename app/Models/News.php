<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $text
 * @property boolean $is_published
 * @property Carbon $published_at
 */

class News extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function save(array $options = [])
    {
        if ($this->exists && $this->isDirty('slug'))
        {
            $oldSlug = $this->getOriginal('slug');
            $newSlug = $this->slug;

            $redirect = new Redirect();
            $redirect->old_slug = route('news_item', ['slug' => $oldSlug], false);
            $redirect->new_slug = route('news_item', ['slug' => $newSlug], false);
            $redirect->save();
        }
        return parent::save($options);
    }
}
