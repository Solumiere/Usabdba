<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Auth::user()->cartItems()->with('game')->get();
        $total = $items->sum(fn ($i) => $i->quantity * $i->game->price);

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Game $game)
    {
        $item = CartItem::firstOrNew([
            'users_id' => Auth::id(),
            'games_id' => $game->id,
        ]);
        $item->quantity = ($item->quantity ?? 0) + 1;
        $item->save();

        return back()->with('status', 'Игра добавлена в корзину');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->users_id === Auth::id(), 403);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);
        $cartItem->update($data);

        return back();
    }

    public function remove(CartItem $cartItem)
    {
        abort_unless($cartItem->users_id === Auth::id(), 403);
        $cartItem->delete();

        return back()->with('status', 'Товар удалён из корзины');
    }
}
