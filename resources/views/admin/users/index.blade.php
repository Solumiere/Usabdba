@extends('layouts.app')

@section('content')
@include('admin._nav')
<h1 class="section-title">Пользователи</h1>

<div class="card app-card">
    <div class="table-responsive">
        <table class="table table-dark table-borderless align-middle mb-0">
            <thead><tr><th>ID</th><th>Email</th><th>Роль</th><th>Регистрация</th><th></th></tr></thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= e($user->email) ?></td>
                        <td>
                            <form action="<?= route('admin.users.role', $user) ?>" method="POST" class="d-flex gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="form-select form-select-sm" style="width:auto">
                                    <option value="customer" <?= $user->role === 'customer' ? 'selected' : '' ?>>Покупатель</option>
                                    <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Администратор</option>
                                </select>
                                <button class="btn btn-sm btn-outline-light" type="submit">OK</button>
                            </form>
                        </td>
                        <td><?= e($user->created_at?->format('d.m.Y')) ?></td>
                        <td class="text-end">
                            @if ($user->id !== auth()->id())
                                <form action="<?= route('admin.users.destroy', $user) ?>" method="POST" onsubmit="return confirm('Удалить пользователя?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            @else
                                <span class="text-muted small">это вы</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?= $users->links() ?></div>
@endsection
