<?php

namespace App\Models;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['text', 'comment_id', 'post_id', 'user_id'];
    public function commend(): HasMany {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function list() {
        return self::all();
    }

    public static function createOrUpdate($request, $id = null) {
        $comment = [
            'text' => $request->text, 
            'comment_id' => $request->comment_id ?? null, 
            'post_id' => $request->post_id ?? null, 
            'user_id' => $request->user()->id
        ];
        return self::updateOrCreate(['id' => $id], $comment);
    }

}
