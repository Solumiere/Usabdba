@extends('layouts.app')

@section('content')
<h1 class="section-title">Желаемое</h1>

@if ($items->isEmpty())
    <div class="empty-state">
        <i class="bi bi-heart"></i>
        <p>В списке желаемого пока пусто.</p>
        <a href="<?= route('catalog.index') ?>" class="btn btn-buy">В каталог</a>
    </div>
@else
    <div class="row g-3">
        @foreach ($items as $item)
            @php $hasImg = !empty($item->game->image); @endphp
            <div class="col-6 col-md-4 col-lg-3">
                <div class="game-card">
                    <a href="<?= route('catalog.show', $item->game) ?>" class="game-cover <?= $hasImg ? 'has-image' : '' ?>" style="<?= $hasImg ? "background-image:url('".e(asset('storage/'.$item->game->image))."')" : 'background:linear-gradient(135deg,#2b5876,#4e4376)' ?>;">
                        <span class="badge-genre"><?= e($item->game->genre) ?></span>
                        <span class="game-cover-title"><?= e($item->game->title) ?></span>
                    </a>
                    <div class="game-body">
                        <a href="<?= route('catalog.show', $item->game) ?>" class="game-title"><?= e($item->game->title) ?></a>
                        <div class="game-meta"><span class="price"><?= number_format($item->game->price, 0, ',', ' ') ?> ₽</span></div>
                        <div class="d-flex gap-1 mt-2">
                            <form action="<?= route('cart.add', $item->game) ?>" method="POST" class="flex-grow-1">
                                @csrf
                                <button class="btn btn-buy w-100 btn-sm" type="submit">В корзину</button>
                            </form>
                            <form action="<?= route('wishlist.remove', $item) ?>" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
