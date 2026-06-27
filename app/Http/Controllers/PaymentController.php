<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function pay(Order $order)
    {
        abort_unless($order->users_id === Auth::id(), 403);
        abort_if($order->status !== 'pending', 404);
        $order->load('items.game');

        return view('payments.pay', compact('order'));
    }

    public function process(Request $request, Order $order)
    {
        abort_unless($order->users_id === Auth::id(), 403);
        abort_if($order->status !== 'pending', 404);

        // Демо-оплата: создаём платёж и переводим заказ в paid в одной транзакции
        DB::transaction(function () use ($order) {
            Payment::create([
                'orders_id' => $order->id,
                'amount' => $order->total_price,
                'status' => 'success',
                'paid_at' => now(),
            ]);

            $order->update(['status' => 'paid']);
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Оплата заказа #'.$order->id.' прошла успешно');
    }
}
