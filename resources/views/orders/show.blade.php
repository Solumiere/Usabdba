@extends('layouts.app')

@section('content')
@php
    $statusBadge = function ($s) {
        $map = ['pending' => ['status-pending', 'Ожидает оплаты'], 'paid' => ['status-paid', 'Оплачен'], 'cancelled' => ['status-cancelled', 'Отменён']];
        $b = $map[$s] ?? ['status-pending', $s];
        return '<span class="badge '.$b[0].'">'.e($b[1]).'</span>';
    };
@endphp

<a href="<?= route('orders.index') ?>" class="text-muted small"><i class="bi bi-arrow-left"></i> К моим заказам</a>

<div class="d-flex justify-content-between align-items-center mt-2 mb-3">
    <h1 class="section-title mb-0">Заказ #<?= $order->id ?></h1>
    <?= $statusBadge($order->status) ?>
</div>

<div class="card app-card mb-3">
    <div class="table-responsive">
        <table class="table table-dark table-borderless align-middle mb-0">
            <thead><tr><th>Игра</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr></thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td><?= e($item->game->title ?? 'Игра удалена') ?></td>
                        <td><?= number_format($item->price_at_purchase, 0, ',', ' ') ?> ₽</td>
                        <td><?= (int) $item->quantity ?></td>
                        <td><?= number_format($item->price_at_purchase * $item->quantity, 0, ',', ' ') ?> ₽</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="price-lg">Итого: <?= number_format($order->total_price, 0, ',', ' ') ?> ₽</span>
    <div class="d-flex gap-2">
        @if ($order->status === 'pending')
            <a href="<?= route('payments.pay', $order) ?>" class="btn btn-buy btn-lg"><i class="bi bi-credit-card"></i> Оплатить</a>
        @endif
        <a href="<?= route('orders.receipt', $order) ?>" class="btn btn-outline-light"><i class="bi bi-file-earmark-pdf"></i> Квитанция</a>
    </div>
</div>
@endsection
