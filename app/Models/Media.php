<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['image', 'post_id', 'user_id', 'comment_id'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public static function uploadFile($file): string
    {
        $filename = $file->getClientOriginalName(); // get the file name
        $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
        $getfileExtension = $file->getClientOriginalExtension(); // get the file extension
        $newFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; // create new random file name
        $img_path = $file->storeAs('public/images', $newFileName); // get the image path
        return $newFileName;
    }

    public static function createOrUpdate($request)
    {
        foreach ($request['image'] as $image) {
            $image = self::uploadFile($image);
            $media = [
                'image' => $image ?? null,
                'user_id' => $request['user_id'] ?? null,
                'post_id' => $request['post_id'] ?? null,
                'comment_id' => $request['comment_id'] ?? null,
            ];
            self::create($media);
        }
    }
}
