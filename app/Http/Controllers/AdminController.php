<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', ['users' => $users]);
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'unique:users,nip'],
            'username' => ['required', 'string', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,petugas'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menambah user baru: ' . $validated['username'],
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'unique:users,nip,' . $user->id],
            'username' => ['required', 'string', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,petugas'],
        ]);

        $user->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengubah data user: ' . $user->username,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('password'),
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Reset password user: ' . $user->username,
        ]);

        return back()->with('success', 'Password user berhasil direset ke "password".');
    }

    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('search')) {
            $query->where('aktivitas', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->paginate(20);
        $users = User::all();

        return view('admin.activity-logs', [
            'logs' => $logs,
            'users' => $users,
        ]);
    }

    public function deleteUser(User $user)
    {
        $username = $user->username;
        $user->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menghapus user: ' . $username,
        ]);

        return back()->with('success', 'User berhasil dihapus.');
    }
}
