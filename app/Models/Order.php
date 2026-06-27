<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = ['users_id', 'status', 'total_price'];

    protected $casts = [
        'created_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orders_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'orders_id');
    }
}
