<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Requests\User\UserRegisterRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function profile(): HasOne
    {
        return $this->hasOne(Media::class, 'user_id', 'id');
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Media::class, 'user_id', 'id');
    }
    public function friends(): HasMany
    {
        return $this->HasMany(Friend::class, 'is_friend', 1);
    }

    public static function requested($request)
    {
        return Friend::where('is_friend', 0)
                    ->where('user_id', '=', $request->user()->id)
                    // ->orWhere('friend_id', '=', $request->user()->id)
                    ->get();
    }
    public static function createOrUpdate(UserRegisterRequest $request, string $id = null)
    {
        $user = $request->only('first_name', 'last_name', 'email', 'password', 'phone');
        $user = self::updateOrCreate(['id' => $id], $user);
        Media::createOrUpdate(['image' => [$request->image], 'user_id' => $user->id]);
        return $user;
    }
}
