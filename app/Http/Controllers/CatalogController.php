<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::visible();

        // Поиск по названию (параметризованный запрос)
        if ($q = trim((string) $request->input('q'))) {
            $query->where('title', 'like', '%'.$q.'%');
        }

        // Фильтр по жанру
        if ($genre = $request->input('genre')) {
            $query->where('genre', $genre);
        }

        // Сортировка (только из белого списка)
        $sort = (string) $request->input('sort');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'title' => $query->orderBy('title'),
            default => $query->orderByDesc('created_at'),
        };

        $games = $query->paginate(12)->withQueryString();

        $genres = Game::visible()
            ->select('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        return view('catalog.index', compact('games', 'genres'));
    }

    public function show(Game $game)
    {
        abort_if($game->is_hidden, 404);

        return view('catalog.show', compact('game'));
    }
}
