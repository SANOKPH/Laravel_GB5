<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'description', 'user_id'];

    public function medias(): HasMany {
        return $this->hasMany(Media::class, 'post_id', 'id');
    }

    public static function list() {
        return self::all();
    }
    public static function createOrUpdate($request, $id = null) {
        $post = $request->only('title', 'description', 'user_id', 'image');
        $post = self::updateOrCreate(['id' => $id], $post);
        Media::createOrUpdate(['image' => [$request['image']], 'post_id' => $post['id']]);
        return $post;
    }
}