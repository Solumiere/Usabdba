@extends('layouts.app')

@section('content')
@include('admin._nav')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="section-title mb-0">Управление каталогом</h1>
    <a href="<?= route('admin.games.create') ?>" class="btn btn-buy"><i class="bi bi-plus-lg"></i> Добавить игру</a>
</div>

<div class="card app-card">
    <div class="table-responsive">
        <table class="table table-dark table-borderless align-middle mb-0">
            <thead><tr><th>Название</th><th>Жанр</th><th>Цена</th><th>Остаток</th><th>Видимость</th><th></th></tr></thead>
            <tbody>
                @foreach ($games as $game)
                    <tr>
                        <td><?= e($game->title) ?></td>
                        <td><?= e($game->genre) ?></td>
                        <td><?= number_format($game->price, 0, ',', ' ') ?> ₽</td>
                        <td><?= (int) $game->stock ?></td>
                        <td>
                            <form action="<?= route('admin.games.toggle', $game) ?>" method="POST">
                                @csrf
                                @method('PATCH')
                                @if ($game->is_hidden)
                                    <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-eye-slash"></i> Скрыта</button>
                                @else
                                    <button class="btn btn-sm btn-outline-success" type="submit"><i class="bi bi-eye"></i> Видна</button>
                                @endif
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="<?= route('admin.games.edit', $game) ?>" class="btn btn-sm btn-outline-light"><i class="bi bi-pencil"></i></a>
                            <form action="<?= route('admin.games.destroy', $game) ?>" method="POST" class="d-inline" onsubmit="return confirm('Удалить игру?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?= $games->links() ?></div>
@endsection
