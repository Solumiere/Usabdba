<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title ?? 'GameStore — магазин видеоигр') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= asset('css/app.css') ?>" rel="stylesheet">
</head>
<body>
<header class="app-nav">
    <div class="container app-nav-inner">
        <a class="brand" href="<?= route('catalog.index') ?>"><span class="brand-badge">GAME</span><span class="brand-text">STORE</span></a>
        <a class="btn btn-catalog" href="<?= route('catalog.index') ?>"><i class="bi bi-grid-3x3-gap-fill"></i> КАТАЛОГ</a>
        <form class="search" action="<?= route('catalog.index') ?>" method="GET" role="search">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="<?= e(request('q')) ?>" placeholder="Поиск игр...">
        </form>
        <nav class="app-actions">
            @auth
                <a class="icon-link" href="<?= route('wishlist.index') ?>" title="Желаемое"><i class="bi bi-heart"></i></a>
                <a class="icon-link" href="<?= route('cart.index') ?>" title="Корзина"><i class="bi bi-cart"></i></a>
                <a class="icon-link" href="<?= route('orders.index') ?>" title="Заказы"><i class="bi bi-bag"></i></a>
                <div class="dropdown">
                    <button class="icon-link dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="bi bi-person-circle"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted small"><?= e(auth()->user()->email) ?></span></li>
                        <li><hr class="dropdown-divider"></li>
                        @if (auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="<?= route('admin.games.index') ?>">Управление каталогом</a></li>
                            <li><a class="dropdown-item" href="<?= route('admin.orders.index') ?>">Все заказы</a></li>
                            <li><a class="dropdown-item" href="<?= route('admin.users.index') ?>">Пользователи</a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form action="<?= route('logout') ?>" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">Выйти</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="icon-link" href="<?= route('wishlist.index') ?>" title="Желаемое"><i class="bi bi-heart"></i></a>
                <a class="icon-link" href="<?= route('cart.index') ?>" title="Корзина"><i class="bi bi-cart"></i></a>
                <a class="btn btn-login" href="<?= route('login') ?>">Войти</a>
            @endauth
        </nav>
    </div>
</header>

<main class="container py-4">
    @if (session('status'))
        <div class="alert alert-success"><?= e(session('status')) ?></div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><?= e($error) ?></li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>

<footer class="app-footer">
    <div class="container">GameStore © <?= date('Y') ?> — учебный проект (ГБПОУ ИО «ИАТ»)</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
