<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $fillable = ['type'];

    public static function createOrUpdate($request, $id = null)
    {
        $reaction = $request->only('type');
        $reaction = self::updateOrCreate(['id' => $id], $reaction);
        return $reaction;
    }
}
