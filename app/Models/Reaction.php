<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','type'];

    public static function createOrUpdate($request, $id = null)
    {
        $reaction = $request->only('user_id','type');
        $reaction = self::updateOrCreate(['id' => $id], $reaction);
        return $reaction;
    }
}
