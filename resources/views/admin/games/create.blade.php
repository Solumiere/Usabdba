@extends('layouts.app')

@section('content')
@include('admin._nav')
<h1 class="section-title">Новая игра</h1>
<div class="card app-card">
    <form action="<?= route('admin.games.store') ?>" method="POST">
        @csrf
        @include('admin.games._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-buy" type="submit">Сохранить</button>
            <a href="<?= route('admin.games.index') ?>" class="btn btn-outline-light">Отмена</a>
        </div>
    </form>
</div>
@endsection
