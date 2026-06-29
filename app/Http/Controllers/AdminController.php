<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menghapus user: ' . $username,
        ]);

        return back()->with('success', 'User berhasil deleted.');
    }

    // ==========================================
    // FITUR PROFIL MANDIRI + FOTO
    // ==========================================

    public function profile()
    {
        return view('admin.profile', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')->store('avatars', 'public');
            $validated['foto'] = $path;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->fill($validated);
        $user->save();

        ActivityLog::create([
            'user_id' => $user->id,
            'aktivitas' => 'Memperbarui data profil dan foto mandiri',
        ]);

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function deleteFoto()
    {
        $user = User::findOrFail(Auth::id());

        if ($user->foto) {
            if (Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->update(['foto' => null]);

            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Menghapus foto profil',
            ]);

            return back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return back()->with('error', 'Anda tidak memiliki foto profil untuk dihapus.');
    }
}