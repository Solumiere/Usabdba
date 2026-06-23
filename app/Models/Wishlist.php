<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps = false;
    protected $table = 'wishlist';

    protected $fillable = ['users_id', 'games_id'];

    public function game()
    {
        return $this->belongsTo(Game::class, 'games_id');
    }
}
