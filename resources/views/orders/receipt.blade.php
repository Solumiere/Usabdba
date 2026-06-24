<h1 style="font-size:16px">Квитанция по заказу #<?= (int) $order->id ?></h1>
<p>Дата: <?= e($order->created_at) ?></p>
<p>Статус: <?= e($order->status) ?></p>
<table border="1" cellpadding="4">
  <thead>
    <tr>
      <th>Игра</th>
      <th>Цена</th>
      <th>Кол-во</th>
      <th>Сумма</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($order->items as $item)
    <tr>
      <td><?= e($item->game->title) ?></td>
      <td><?= number_format($item->price_at_purchase, 2, ',', ' ') ?> руб.</td>
      <td><?= (int) $item->quantity ?></td>
      <td><?= number_format($item->price_at_purchase * $item->quantity, 2, ',', ' ') ?> руб.</td>
    </tr>
  @endforeach
  </tbody>
</table>
<h3 style="font-size:14px">Итого: <?= number_format($order->total_price, 2, ',', ' ') ?> руб.</h3>
