<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    // День 10 — история заказов текущего покупателя
    public function index()
    {
        $orders = Auth::user()->orders()->orderByDesc('created_at')->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Всё в транзакции: либо заказ создаётся целиком, либо откат
        $order = DB::transaction(function () use ($user) {
            $items = $user->cartItems()->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages(['cart' => 'Корзина пуста']);
            }

            $total = 0;
            $prepared = [];

            // Блокируем строки игр и проверяем остаток
            foreach ($items as $item) {
                $game = Game::whereKey($item->games_id)->lockForUpdate()->first();

                if (! $game) {
                    throw ValidationException::withMessages(['cart' => 'Игра недоступна']);
                }
                if ($game->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'Недостаточно на складе: '.$game->title,
                    ]);
                }

                $total += $game->price * $item->quantity;
                $prepared[] = ['game' => $game, 'quantity' => $item->quantity];
            }

            $order = Order::create([
                'users_id' => $user->id,
                'status' => 'pending',
                'total_price' => $total,
            ]);

            foreach ($prepared as $row) {
                $order->items()->create([
                    'games_id' => $row['game']->id,
                    'price_at_purchase' => $row['game']->price, // фиксируем цену на момент покупки
                    'quantity' => $row['quantity'],
                ]);
                $row['game']->decrement('stock', $row['quantity']);
            }

            $user->cartItems()->delete();

            return $order;
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Заказ #'.$order->id.' оформлен');
    }

    public function show(Order $order)
    {
        abort_unless($order->users_id === Auth::id(), 403);
        $order->load('items.game');

        return view('orders.show', compact('order'));
    }

    // День 10 — квитанция в PDF через TCPDF
    public function receipt(Order $order)
    {
        abort_unless($order->users_id === Auth::id(), 403);
        $order->load('items.game');

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
        $pdf->SetCreator('GameStore');
        $pdf->SetTitle('Квитанция #'.$order->id);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 11); // юникод-шрифт для кириллицы

        $html = view('orders.receipt', compact('order'))->render();
        $pdf->writeHTML($html, true, false, true, false, '');

        return response(
            $pdf->Output('receipt-'.$order->id.'.pdf', 'S'),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="receipt-'.$order->id.'.pdf"',
            ]
        );
    }
}
