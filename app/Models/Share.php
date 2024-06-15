<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Share extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'user_id'];


    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function list($user_id)
    {
        $posts = Post::join('shares', 'posts.id', '=', 'shares.post_id')
            ->where('shares.user_id', $user_id)
            ->select('posts.*')
            ->distinct()
            ->get();
        return $posts;
    }
    public static function createOrUpdate($request, $id = null)
    {
        $share = [
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id
        ];
        $share = self::updateOrCreate(['id' => $id], $share);
        return $share;
    }

    public static function deleteShare($request, $id): bool
    {
        $user_id = $request->user()->id;

        $is_deleted = Share::where('user_id', $user_id)
                            ->where('post_id', $id)
                            ->delete();
        return $is_deleted ? true : false;
    }
}