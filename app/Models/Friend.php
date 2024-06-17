<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'friend_id', 'is_friend'];

    public function friends(): HasMany {
        return $this->hasMany(self::class, 'is_friend', 1);
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id', 'id');
    }


    public static function list($request) 
    {
        return self::where('user_id', $request->user()->id)
                    ->orWhere('friend_id', $request->user()->id)
                    ->where('is_friend', 1)
                    ->get();
    }

    public static function requestedFromFriend($request) // get users we requested to
    {
        $friends = self::where('friend_id', $request->user()->id)
                        ->where('is_friend', 0)
                        ->get();
        return $friends;
    }

    public static function requestedToFriend($request) // get users we requested to
    {
        $friends = self::where('user_id', $request->user()->id)
                        ->where('is_friend', 0)
                        ->get();
        return $friends;
    }

    public static function accept($request)
    {
        $friend_request = self::where('user_id', $request->friend_id)
                            ->where('friend_id',  $request->user()->id)
                            ->where('is_friend', 0)
                            ->first();

        if(!$friend_request) return false; 
        $friend_request->is_friend = 1;
        $friend_request->save();

        $request['is_friend'] = 1;
        self::createOrUpdate($request);

        return $friend_request;
    }

    public static function unfriend($request, $id) {
        $user_id = $request->user()->id;
        $friend = self::where('user_id', $user_id)
                      ->where('friend_id', $id)
                      ->orWhere('user_id', $id)
                      ->where('friend_id', $user_id)
                      ->where('is_friend', 1)
                      ->delete();

        return $friend; 
    }

    public static function createOrUpdate($request, $id = null)
    {
        if (self::where('friend_id', $request->friend_id)->where('user_id', $request->user()->id)->exists()) return false;
        $friend = [
            'user_id' => $request->user()->id,
            'friend_id' => $request->friend_id,
            'is_friend' => $request->is_friend ?? 0
        ];
        $friend = self::updateOrCreate(['id' => $id], $friend);
        return $friend;
    }
}
