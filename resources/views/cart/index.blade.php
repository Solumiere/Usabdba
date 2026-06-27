@extends('layouts.app')

@section('content')
<h1 class="section-title">Корзина</h1>

@if ($items->isEmpty())
    <div class="empty-state">
        <i class="bi bi-cart-x"></i>
        <p>Корзина пуста.</p>
        <a href="<?= route('catalog.index') ?>" class="btn btn-buy">В каталог</a>
    </div>
@else
    <div class="card app-card">
        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle mb-0">
                <thead><tr><th>Игра</th><th>Цена</th><th style="width:150px">Кол-во</th><th>Сумма</th><th></th></tr></thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <a href="<?= route('catalog.show', $item->game) ?>" class="game-title"><?= e($item->game->title) ?></a>
                                <div class="text-muted small"><?= e($item->game->genre) ?></div>
                            </td>
                            <td><?= number_format($item->game->price, 0, ',', ' ') ?> ₽</td>
                            <td>
                                <form action="<?= route('cart.update', $item) ?>" method="POST" class="d-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="<?= (int) $item->quantity ?>" min="1" max="<?= (int) $item->game->stock ?>" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-outline-light" type="submit"><i class="bi bi-arrow-repeat"></i></button>
                                </form>
                            </td>
                            <td><?= number_format($item->game->price * $item->quantity, 0, ',', ' ') ?> ₽</td>
                            <td>
                                <form action="<?= route('cart.remove', $item) ?>" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <span class="price-lg">Итого: <?= number_format($total, 0, ',', ' ') ?> ₽</span>
        <form action="<?= route('orders.store') ?>" method="POST">
            @csrf
            <button class="btn btn-buy btn-lg" type="submit">Оформить заказ</button>
        </form>
    </div>
    @error('cart')
        <div class="alert alert-danger mt-2"><?= e($message) ?></div>
    @enderror
@endif
@endsection
