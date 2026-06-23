@extends('layouts.app')
@section('title', 'Список желаемого')
@section('content')
<h1 class="h4 mb-3">Список желаемого</h1>
@if ($items->isEmpty())
  <p>Список пуст.</p>
@else
  <div class="row g-3">
    @foreach ($items as $item)
      <div class="col-sm-6 col-lg-4">
        <div class="card h-100"><div class="card-body d-flex flex-column">
          <h5 class="card-title"><?= e($item->game->title) ?></h5>
          <p class="fw-bold"><?= number_format($item->game->price, 2, ',', ' ') ?> ₽</p>
          <div class="mt-auto d-flex gap-2">
            <form method="POST" action="<?= route('cart.add', $item->game) ?>">@csrf
              <button class="btn btn-sm btn-primary">В корзину</button>
            </form>
            <form method="POST" action="<?= route('wishlist.remove', $item) ?>">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Убрать</button>
            </form>
          </div>
        </div></div>
      </div>
    @endforeach
  </div>
@endif
@endsection
