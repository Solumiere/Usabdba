<div class="admin-nav">
    <a href="<?= route('admin.games.index') ?>" class="<?= request()->routeIs('admin.games.*') ? 'active' : '' ?>"><i class="bi bi-controller"></i> Каталог</a>
    <a href="<?= route('admin.orders.index') ?>" class="<?= request()->routeIs('admin.orders.*') ? 'active' : '' ?>"><i class="bi bi-receipt"></i> Заказы</a>
    <a href="<?= route('admin.users.index') ?>" class="<?= request()->routeIs('admin.users.*') ? 'active' : '' ?>"><i class="bi bi-people"></i> Пользователи</a>
</div>
