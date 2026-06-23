<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title>@yield('title', 'Магазин видеоигр')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= route('catalog.index') ?>">🎮 GameStore</a>
    <ul class="navbar-nav ms-auto">
      @auth
        <li class="nav-item"><a class="nav-link" href="<?= route('wishlist.index') ?>">Желаемое</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= route('cart.index') ?>">Корзина</a></li>
        <li class="nav-item"><span class="nav-link text-white-50"><?= e(auth()->user()->email) ?></span></li>
        <li class="nav-item">
          <form method="POST" action="<?= route('logout') ?>">@csrf
            <button class="btn btn-sm btn-outline-light mt-1">Выйти</button>
          </form>
        </li>
      @else
        <li class="nav-item"><a class="nav-link" href="<?= route('login') ?>">Вход</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= route('register') ?>">Регистрация</a></li>
      @endauth
    </ul>
  </div>
</nav>

<main class="container py-4">
  @if (session('status'))
    <div class="alert alert-success"><?= e(session('status')) ?></div>
  @endif
  @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
