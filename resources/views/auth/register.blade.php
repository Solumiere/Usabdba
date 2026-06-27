@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="card app-card auth-card">
        <h1 class="section-title text-center">Регистрация</h1>
        <form action="<?= route('register') ?>" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="<?= e(old('email')) ?>" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Повторите пароль</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-buy w-100 btn-lg" type="submit">Создать аккаунт</button>
        </form>
        <p class="text-center text-muted mt-3 mb-0">Уже есть аккаунт? <a href="<?= route('login') ?>">Войти</a></p>
    </div>
</div>
@endsection
