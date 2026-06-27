@extends('layouts.app')

@section('content')
@include('admin._nav')
@php
    $statusBadge = function ($s) {
        $map = ['pending' => ['status-pending', 'Ожидает оплаты'], 'paid' => ['status-paid', 'Оплачен'], 'cancelled' => ['status-cancelled', 'Отменён']];
        $b = $map[$s] ?? ['status-pending', $s];
        return '<span class="badge '.$b[0].'">'.e($b[1]).'</span>';
    };
@endphp

<a href="<?= route('admin.orders.index') ?>" class="text-muted small"><i class="bi bi-arrow-left"></i> Ко всем заказам</a>

<div class="d-flex justify-content-between align-items-center mt-2 mb-3">
    <h1 class="section-title mb-0">Заказ #<?= $order->id ?></h1>
    <?= $statusBadge($order->status) ?>
</div>

<div class="card app-card mb-3">
    <p class="mb-1">Покупатель: <strong><?= e($order->user->email ?? '—') ?></strong></p>
    <p class="mb-1">Дата: <?= e($order->created_at?->format('d.m.Y H:i')) ?></p>
    @if ($order->payment)
        <p class="mb-0">Оплата: <?= number_format($order->payment->amount, 0, ',', ' ') ?> ₽, статус <?= e($order->payment->status) ?>, <?= e($order->payment->paid_at?->format('d.m.Y H:i')) ?></p>
    @endif
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
    <form action="<?= route('admin.orders.status', $order) ?>" method="POST" class="d-flex gap-2">
        @csrf
        @method('PATCH')
        <select name="status" class="form-select" style="width:auto">
            <option value="pending" <?= $order->status === 'pending' ? 'selected' : '' ?>>Ожидает оплаты</option>
            <option value="paid" <?= $order->status === 'paid' ? 'selected' : '' ?>>Оплачен</option>
            <option value="cancelled" <?= $order->status === 'cancelled' ? 'selected' : '' ?>>Отменён</option>
        </select>
        <button class="btn btn-buy" type="submit">Обновить статус</button>
    </form>
</div>
@endsection
