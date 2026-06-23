@extends('layouts.app')
@section('title', 'Регистрация')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
  <div class="card card-body">
    <h1 class="h4 mb-3">Регистрация</h1>
    <form method="POST" action="<?= route('register') ?>">@csrf
      <input name="email" type="email" value="<?= e(old('email')) ?>" class="form-control mb-2" placeholder="Email">
      @error('email')<div class="text-danger small"><?= e($message) ?></div>@enderror
      <input name="password" type="password" class="form-control mb-2" placeholder="Пароль">
      @error('password')<div class="text-danger small"><?= e($message) ?></div>@enderror
      <input name="password_confirmation" type="password" class="form-control mb-3" placeholder="Повторите пароль">
      <button class="btn btn-primary w-100">Зарегистрироваться</button>
    </form>
  </div>
</div></div>
@endsection
