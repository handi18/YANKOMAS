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
        $users = User::orderBy('updated_at', 'desc')->paginate(15);
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
        ], [
            'password.min' => 'Password harus minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
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
        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Akun Super Admin tidak dapat dimodifikasi.');
        }

        return view('admin.users.edit', ['user' => $user]);
    }

    public function updateUser(Request $request, User $user)
    {
        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Akun Super Admin tidak dapat dimodifikasi.');
        }
        if ($request->role === 'super_admin' && !Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang dapat memberikan role Super Admin.');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'unique:users,nip,' . $user->id],
            'username' => ['required', 'string', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,petugas,super_admin'],
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
        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Akun Super Admin tidak dapat di-reset passwordnya.');
        }

        // Diubah langsung menggunakan 'password123'
        $user->update([
            'password' => Hash::make('password123'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Reset password user: ' . $user->username,
        ]);

        return back()->with('success', 'Password berhasil di-reset menjadi password123');
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
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

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
        ], [
            'password.min' => 'Password baru harus minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.'
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