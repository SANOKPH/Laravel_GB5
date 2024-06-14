<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'friend_id', 'is_friend'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id', 'id');
    }


    public static function requested($request) {
        return self::where('user_id', $request->user()->id)->where('is_friend', 0)->get();
    }

    public static function createOrUpdate($request, $id = null)
    {
        if(self::where('friend_id', $request->friend_id)->exists()) return false;
        $friend = [
            'user_id' => $request->user()->id, 
            'friend_id' => $request->friend_id
        ];
        $friend = self::updateOrCreate(['id' => $id], $friend);
        return $friend;
    }
}