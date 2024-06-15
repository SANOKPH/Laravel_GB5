<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'description', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function medias(): HasMany
    {
        return $this->hasMany(Media::class, 'post_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }



    public static function list(string $user_id)
    {
        $posts = self::where('user_id', $user_id)->get();
        return $posts;
    }
    public static function createOrUpdate($request, $id = null)
    {
        $post = [
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => $request->user()->id
        ];
        $post = self::updateOrCreate(['id' => $id], $post);

        $media_request = ['image' => [$request['image']], 'post_id' => $post['id']];

        Media::createOrUpdate($media_request);

        return $post;
    }
}
