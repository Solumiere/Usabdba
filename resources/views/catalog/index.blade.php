@extends('layouts.app')

@section('content')
<section class="hero">
    <div class="hero-content">
        <span class="hero-eyebrow">НОВИНКИ И ХИТЫ</span>
        <h1 class="hero-title">Лучшие видеоигры<br>по честным ценам</h1>
        <p class="hero-sub">Десятки игр всех жанров — от инди до больших релизов. Собирай вишлист и получай квитанции на каждый заказ.</p>
        <a href="#catalog" class="btn btn-buy btn-lg">Смотреть каталог</a>
    </div>
</section>

<div id="catalog" class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-5 mb-3">
    <h2 class="section-title mb-0">Каталог игр</h2>
    <form class="filters" action="<?= route('catalog.index') ?>" method="GET">
        <input type="search" name="q" value="<?= e(request('q')) ?>" class="form-control form-control-sm" placeholder="Название...">
        <select name="genre" class="form-select form-select-sm">
            <option value="">Все жанры</option>
            @foreach ($genres as $g)
                <option value="<?= e($g) ?>" <?= request('genre') === $g ? 'selected' : '' ?>><?= e($g) ?></option>
            @endforeach
        </select>
        <button class="btn btn-sm btn-buy" type="submit">Фильтр</button>
    </form>
</div>

@php
    $palette = [['#7b2ff7','#f107a3'],['#11998e','#38ef7d'],['#e4002b','#ff7e5f'],['#2b5876','#4e4376'],['#f7971e','#ffd200'],['#373b44','#4286f4']];
    $cover = function ($game) use ($palette) {
        $pair = $palette[$game->id % count($palette)];
        return 'linear-gradient(135deg, '.$pair[0].', '.$pair[1].')';
    };
@endphp

<div class="row g-3">
    @forelse ($games as $game)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="game-card">
                <a href="<?= route('catalog.show', $game) ?>" class="game-cover" style="background:<?= $cover($game) ?>;">
                    <span class="badge-genre"><?= e($game->genre) ?></span>
                    <span class="game-cover-title"><?= e($game->title) ?></span>
                </a>
                <div class="game-body">
                    <a href="<?= route('catalog.show', $game) ?>" class="game-title"><?= e($game->title) ?></a>
                    <div class="game-meta">
                        <span class="price"><?= number_format($game->price, 0, ',', ' ') ?> ₽</span>
                        @if ($game->stock > 0)
                            <span class="stock-ok">в наличии</span>
                        @else
                            <span class="stock-no">нет</span>
                        @endif
                    </div>
                    <a href="<?= route('catalog.show', $game) ?>" class="btn btn-buy w-100 mt-2">Подробнее</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Игры не найдены.</p>
    @endforelse
</div>

<div class="mt-4"><?= $games->links() ?></div>
@endsection
