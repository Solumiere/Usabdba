@extends('layouts.app')

@section('content')
@php
    $statusBadge = function ($s) {
        $map = ['pending' => ['status-pending', 'Ожидает оплаты'], 'paid' => ['status-paid', 'Оплачен'], 'cancelled' => ['status-cancelled', 'Отменён']];
        $b = $map[$s] ?? ['status-pending', $s];
        return '<span class="badge '.$b[0].'">'.e($b[1]).'</span>';
    };
@endphp
<h1 class="section-title">Мои заказы</h1>

@if ($orders->isEmpty())
    <div class="empty-state">
        <i class="bi bi-bag"></i>
        <p>У вас пока нет заказов.</p>
        <a href="<?= route('catalog.index') ?>" class="btn btn-buy">В каталог</a>
    </div>
@else
    <div class="card app-card">
        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle mb-0">
                <thead><tr><th>№</th><th>Дата</th><th>Сумма</th><th>Статус</th><th></th></tr></thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#<?= $order->id ?></td>
                            <td><?= e($order->created_at?->format('d.m.Y H:i')) ?></td>
                            <td><?= number_format($order->total_price, 0, ',', ' ') ?> ₽</td>
                            <td><?= $statusBadge($order->status) ?></td>
                            <td class="text-end"><a href="<?= route('orders.show', $order) ?>" class="btn btn-sm btn-outline-light">Открыть</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3"><?= $orders->links() ?></div>
@endif
@endsection
