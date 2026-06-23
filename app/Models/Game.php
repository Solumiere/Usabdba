<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'price', 'genre', 'stock', 'is_hidden'];

    protected $casts = [
        'is_hidden' => 'boolean',
        'price' => 'decimal:2',
    ];

    // только видимые игры в каталоге
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }
}
