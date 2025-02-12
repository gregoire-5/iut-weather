<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCity extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'is_favorite', 'send_forecast'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function setFavorite($id, $userId)
    {
        self::where('user_id', $userId)->update(['is_favorite' => false]);
        $city = self::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $city->is_favorite = true;
        $city->save();

        return $city;
    }
}