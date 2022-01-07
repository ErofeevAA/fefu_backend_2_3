<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $author
 * @property string $text
 * @property int $user_id
 * @property int $post_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

class Comment extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeOrdered(Builder $builder): Builder
    {
        return $builder
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }
}
