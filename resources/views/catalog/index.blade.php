@extends('layouts.app')
@section('title', 'Каталог')
@section('content')
<div class="row">
  <aside class="col-md-3 mb-4">
    <form method="GET" class="card card-body">
      <h6>Фильтры</h6>
      <input type="text" name="search" value=" request('search') " class="form-control mb-2" placeholder="Поиск...">
      <select name="genre" class="form-select mb-2">
        <option value="">Все жанры</option>
        @foreach ($genres as $g)
          <option value=" $g " @selected(request('genre') == $g)> $g </option>
        @endforeach
      </select>
      <div class="d-flex gap-2 mb-2">
        <input type="number" name="min_price" value=" request('min_price') " class="form-control" placeholder="от">
        <input type="number" name="max_price" value=" request('max_price') " class="form-control" placeholder="до">
      </div>
      <select name="sort" class="form-select mb-2">
        <option value="">По новизне</option>
        <option value="price_asc" @selected(request('sort') == 'price_asc')>Цена ↑</option>
        <option value="price_desc" @selected(request('sort') == 'price_desc')>Цена ↓</option>
        <option value="title" @selected(request('sort') == 'title')>По названию</option>
      </select>
      <button class="btn btn-primary">Применить</button>
    </form>
  </aside>

  <div class="col-md-9">
    <div class="row g-3">
      @forelse ($games as $game)
        <div class="col-sm-6 col-lg-4">
          <div class="card h-100"><div class="card-body d-flex flex-column">
            <h5 class="card-title"> $game->title </h5>
            <p class="text-muted small mb-1"> $game->genre </p>
            <p class="fw-bold"> number_format($game->price, 2, ',', ' ')  ₽</p>
            <a href=" route('catalog.show', $game) " class="btn btn-outline-primary mt-auto">Подробнее</a>
          </div></div>
        </div>
      @empty
        <p>Ничего не найдено.</p>
      @endforelse
    </div>
    <div class="mt-3"> $games->links() </div>
  </div>
</div>
@endsection
