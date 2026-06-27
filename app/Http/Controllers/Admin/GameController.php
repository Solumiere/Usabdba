<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::orderByDesc('created_at')->paginate(20);

        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        Game::create($this->validated($request));

        return redirect()->route('admin.games.index')->with('status', 'Игра добавлена');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $game->update($this->validated($request));

        return redirect()->route('admin.games.index')->with('status', 'Игра обновлена');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return back()->with('status', 'Игра удалена');
    }

    public function toggleHidden(Game $game)
    {
        $game->update(['is_hidden' => ! $game->is_hidden]);

        return back();
    }

    // Серверная валидация данных игры
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'genre' => ['required', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0', 'max:255'],
        ]);

        $data['is_hidden'] = $request->boolean('is_hidden');

        return $data;
    }
}
