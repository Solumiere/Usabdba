<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Auth::user()->wishlist()->with('game')->get();

        return view('wishlist.index', compact('items'));
    }

    public function add(Game $game)
    {
        Wishlist::firstOrCreate([
            'users_id' => Auth::id(),
            'games_id' => $game->id,
        ]);

        return back()->with('status', 'Добавлено в желаемое');
    }

    public function remove(Wishlist $wishlist)
    {
        abort_unless($wishlist->users_id === Auth::id(), 403);
        $wishlist->delete();

        return back();
    }
}
