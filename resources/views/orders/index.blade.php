@extends('layouts.app')
@section('title', 'Мои заказы')
@section('content')
<h1 class="h4 mb-3">Мои заказы</h1>
@if ($orders->isEmpty())
  <p>У вас пока нет заказов.</p>
@else
  <table class="table align-middle bg-white">
    <thead><tr><th>#</th><th>Дата</th><th>Статус</th><th>Сумма</th><th></th></tr></thead>
    <tbody>
    @foreach ($orders as $order)
      <tr>
        <td><?= (int) $order->id ?></td>
        <td><?= e($order->created_at) ?></td>
        <td><?= e($order->status) ?></td>
        <td><?= number_format($order->total_price, 2, ',', ' ') ?> ₽</td>
        <td>
          <a href="<?= route('orders.show', $order) ?>" class="btn btn-sm btn-outline-primary">Подробнее</a>
          <a href="<?= route('orders.receipt', $order) ?>" class="btn btn-sm btn-outline-secondary">Квитанция PDF</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="mt-3"><?= $orders->links() ?></div>
@endif
@endsection
