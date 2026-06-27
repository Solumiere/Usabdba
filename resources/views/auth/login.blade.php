@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="card app-card auth-card">
        <h1 class="section-title text-center">Вход</h1>
        <form action="<?= route('login') ?>" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="<?= e(old('email')) ?>" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-buy w-100 btn-lg" type="submit">Войти</button>
        </form>
        <p class="text-center text-muted mt-3 mb-0">Нет аккаунта? <a href="<?= route('register') ?>">Регистрация</a></p>
    </div>
</div>
@endsection
