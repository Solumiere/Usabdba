@extends('layouts.app')
@section('title', 'Заказ #'.$order->id)
@section('content')
<div class="card card-body">
  <h1 class="h4">Заказ #<?= (int) $order->id ?></h1>
  <p class="text-muted">Статус: <?= e($order->status) ?></p>
  <table class="table">
    <thead><tr><th>Игра</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr></thead>
    <tbody>
    @foreach ($order->items as $item)
      <tr>
        <td><?= e($item->game->title) ?></td>
        <td><?= number_format($item->price_at_purchase, 2, ',', ' ') ?> ₽</td>
        <td><?= (int) $item->quantity ?></td>
        <td><?= number_format($item->price_at_purchase * $item->quantity, 2, ',', ' ') ?> ₽</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <strong class="fs-5">Итого: <?= number_format($order->total_price, 2, ',', ' ') ?> ₽</strong>
  <div class="mt-3">
    <a href="<?= route('catalog.index') ?>" class="btn btn-outline-primary">В каталог</a>
  </div>
</div>
@endsection
