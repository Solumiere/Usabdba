<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['users_id', 'games_id', 'quantity'];

    public function game()
    {
        return $this->belongsTo(Game::class, 'games_id');
    }
}
