<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Like extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'comment_id', 'user_id', 'reaction_id', 'like_count'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public static function createOrUpdate($request, $id = null)
    {
        $like = [
            'post_id' => $request->post_id ?? null,
            'comment_id' => $request->comment_id ?? null,
            'user_id' => $request->user()->id,
            'reaction_id' => $request->reaction_id
        ];
        $like = self::updateOrCreate(['id' => $id], $like);
        return $like;
    }
}
