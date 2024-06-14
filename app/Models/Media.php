<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['image', 'post_id'];

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }

    public static function uploadFile($file): string {
        $filename = $file->getClientOriginalName(); // get the file name
        $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
        $getfileExtension = $file->getClientOriginalExtension(); // get the file extension
        $newFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; // create new random file name
        $img_path = $file->storeAs('public/images/posts', $newFileName); // get the image path
        // $file->storeAs('public/images/posts', $newFileName);        
        return $newFileName;
    }

    public static function createOrUpdate($request, $id = null) {
        foreach ($request['image'] as $image) {
            $image = self::uploadFile($image);
            $media = ['image' => $image, 'post_id' => $request['post_id']];
            $media = self::updateOrCreate(['id' => $id], $media);
        }
    }
}