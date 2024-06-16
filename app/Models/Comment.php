<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['text', 'comment_id', 'post_id', 'user_id'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public static function createOrUpdate($request, $id = null)
    {
        $user_id = $request->user()->id;
        $comment = [
            'text' => $request->text,
            'comment_id' => $request->comment_id ?? null,
            'post_id' => $request->post_id ?? null,
            'user_id' => $user_id
        ];

        $comment = self::updateOrCreate(['id' => $id], $comment);

        if ($request['image']) {
            $media_request = ['image' => [$request['image']], 'post_id' => $comment['id']];
            Media::createOrUpdate($media_request);
        }

        return $comment;
    }
}
