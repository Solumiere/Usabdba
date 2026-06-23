@extends('layouts.app')
@section('title', $game->title)
@section('content')
<div class="card card-body">
  <h1 class="h3"> $game->title </h1>
  <p class="text-muted"> $game->genre </p>
  <p> $game->description </p>
  <p class="fs-4 fw-bold"> number_format($game->price, 2, ',', ' ')  ₽</p>
  <p class="small text-muted">В наличии:  (int) $game->stock </p>
  @auth
    <div class="d-flex gap-2">
      <form method="POST" action=" route('cart.add', $game) ">@csrf
        <button class="btn btn-primary">В корзину</button>
      </form>
      <form method="POST" action=" route('wishlist.add', $game) ">@csrf
        <button class="btn btn-outline-secondary">В желаемое</button>
      </form>
    </div>
  @else
    <a href=" route('login') " class="btn btn-primary">Войдите, чтобы купить</a>
  @endauth
</div>
@endsection
