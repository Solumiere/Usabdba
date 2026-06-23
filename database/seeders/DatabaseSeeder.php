<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@store.local',
            'password_hash' => Hash::make('password'), // bcrypt
            'role' => 'admin',
        ]);

        $games = [
            ['Cyber Drive', 'Гонки', 1999.00, 25],
            ['Shadow Realm', 'RPG', 3499.00, 12],
            ['Empire Builder', 'Стратегия', 1299.00, 40],
            ['Neon Blaster', 'Экшен', 2799.00, 8],
            ['Pixel Quest', 'Инди', 599.00, 100],
        ];

        foreach ($games as [$title, $genre, $price, $stock]) {
            Game::create([
                'title' => $title,
                'description' => 'Описание игры '.$title.'.',
                'price' => $price,
                'genre' => $genre,
                'stock' => $stock,
                'is_hidden' => false,
            ]);
        }
    }
}
