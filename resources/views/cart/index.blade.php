@extends('layouts.app')
@section('title', 'Корзина')
@section('content')
<h1 class="h4 mb-3">Корзина</h1>
@if ($items->isEmpty())
  <p>Корзина пуста.</p>
@else
  <table class="table align-middle bg-white">
    <thead><tr><th>Игра</th><th>Цена</th><th>Кол-во</th><th>Сумма</th><th></th></tr></thead>
    <tbody>
    @foreach ($items as $item)
      <tr>
        <td><?= e($item->game->title) ?></td>
        <td><?= number_format($item->game->price, 2, ',', ' ') ?> ₽</td>
        <td>
          <form method="POST" action="<?= route('cart.update', $item) ?>" class="d-flex gap-1">
            @csrf @method('PATCH')
            <input type="number" name="quantity" value="<?= (int) $item->quantity ?>" min="1" max="99" class="form-control form-control-sm" style="width:80px">
            <button class="btn btn-sm btn-outline-secondary">OK</button>
          </form>
        </td>
        <td><?= number_format($item->quantity * $item->game->price, 2, ',', ' ') ?> ₽</td>
        <td>
          <form method="POST" action="<?= route('cart.remove', $item) ?>">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Удалить</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="d-flex justify-content-between align-items-center">
    <strong class="fs-5">Итого: <?= number_format($total, 2, ',', ' ') ?> ₽</strong>
    <button class="btn btn-success" disabled>Оформить заказ (День 9)</button>
  </div>
@endif
@endsection
