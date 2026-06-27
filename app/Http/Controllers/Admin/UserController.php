<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'in:customer,admin'],
        ]);

        $user->update($data);

        return back()->with('status', 'Роль обновлена');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === Auth::id(), 403); // нельзя удалить самого себя
        $user->delete();

        return back()->with('status', 'Пользователь удалён');
    }
}
