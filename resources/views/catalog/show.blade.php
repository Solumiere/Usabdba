@extends('layouts.app')

@section('content')
@php
    $palette = [['#7b2ff7','#f107a3'],['#11998e','#38ef7d'],['#e4002b','#ff7e5f'],['#2b5876','#4e4376'],['#f7971e','#ffd200'],['#373b44','#4286f4']];
    $pair = $palette[$game->id % count($palette)];
    $hasImg = !empty($game->image);
@endphp

<a href="<?= route('catalog.index') ?>" class="text-muted small"><i class="bi bi-arrow-left"></i> К каталогу</a>

<div class="row g-4 mt-1">
    <div class="col-md-5">
        <div class="game-cover game-cover-lg <?= $hasImg ? 'has-image' : '' ?>" style="<?= $hasImg ? "background-image:url('".e(asset('storage/'.$game->image))."')" : 'background:linear-gradient(135deg, '.$pair[0].', '.$pair[1].')' ?>;">
            <span class="badge-genre"><?= e($game->genre) ?></span>
            <span class="game-cover-title"><?= e($game->title) ?></span>
        </div>
    </div>
    <div class="col-md-7">
        <h1 class="detail-title"><?= e($game->title) ?></h1>
        <div class="mb-3">
            <span class="badge text-bg-secondary"><?= e($game->genre) ?></span>
            @if ($game->stock > 0)
                <span class="badge status-paid">В наличии: <?= (int) $game->stock ?></span>
            @else
                <span class="badge status-cancelled">Нет в наличии</span>
            @endif
        </div>
        <p class="detail-desc"><?= nl2br(e($game->description)) ?></p>
        <div class="price-lg mb-3"><?= number_format($game->price, 0, ',', ' ') ?> ₽</div>
        <div class="d-flex gap-2 flex-wrap">
            @if ($game->stock > 0)
                <form action="<?= route('cart.add', $game) ?>" method="POST">
                    @csrf
                    <button class="btn btn-buy btn-lg" type="submit"><i class="bi bi-cart-plus"></i> Купить</button>
                </form>
            @else
                <button class="btn btn-secondary btn-lg" disabled>Нет в наличии</button>
            @endif
            <form action="<?= route('wishlist.add', $game) ?>" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-lg" type="submit"><i class="bi bi-heart"></i></button>
            </form>
        </div>
    </div>
</div>
@endsection
