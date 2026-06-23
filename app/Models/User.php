<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false; // в таблице только created_at

    protected $fillable = ['email', 'password_hash', 'role'];
    protected $hidden = ['password_hash'];

    // Laravel по умолчанию ищет поле password — указываем наше
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'users_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'users_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'users_id');
    }
}
