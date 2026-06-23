<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['orders_id', 'games_id', 'price_at_purchase', 'quantity'];

    public function game()
    {
        return $this->belongsTo(Game::class, 'games_id');
    }
}
