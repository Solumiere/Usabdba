<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query()->visible();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', '%'.$search.'%'); // параметризовано Eloquent'ом
        }
        if ($genre = $request->input('genre')) {
            $query->where('genre', $genre);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'title' => $query->orderBy('title'),
            default => $query->orderByDesc('created_at'),
        };

        $games = $query->paginate(12)->withQueryString();
        $genres = Game::visible()->select('genre')->distinct()->orderBy('genre')->pluck('genre');

        return view('catalog.index', compact('games', 'genres'));
    }

    public function show(Game $game)
    {
        abort_if($game->is_hidden, 404);

        return view('catalog.show', compact('game'));
    }
}
