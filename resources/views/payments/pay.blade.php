@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="card app-card auth-card">
        <h1 class="section-title text-center">Оплата заказа #<?= $order->id ?></h1>
        <p class="text-center text-muted">К оплате: <span class="price"><?= number_format($order->total_price, 0, ',', ' ') ?> ₽</span></p>
        <form action="<?= route('payments.process', $order) ?>" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Номер карты</label>
                <input type="text" class="form-control" inputmode="numeric" maxlength="19" placeholder="0000 0000 0000 0000" required>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label">Срок</label>
                    <input type="text" class="form-control" placeholder="ММ/ГГ" required>
                </div>
                <div class="col-6">
                    <label class="form-label">CVC</label>
                    <input type="text" class="form-control" maxlength="3" placeholder="000" required>
                </div>
            </div>
            <button class="btn btn-buy w-100 btn-lg" type="submit">Оплатить <?= number_format($order->total_price, 0, ',', ' ') ?> ₽</button>
            <p class="text-center text-muted small mt-3 mb-0">Демонстрационная оплата — реальные деньги не списываются.</p>
        </form>
    </div>
</div>
@endsection
