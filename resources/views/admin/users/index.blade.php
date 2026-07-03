@extends('layouts.app')

@section('title', 'Kelola Petugas')

@section('content')
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users"></i> Kelola Petugas</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Petugas
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->nip }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'superadmin' || $user->isSuperAdmin())
                                    <span class="badge bg-dark">Super Admin</span>
                                @elseif($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-info">Petugas</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-xs custom-tooltip" data-tooltip="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== Auth::id())
                                    @if(!$user->isSuperAdmin())
                                    <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-xs custom-tooltip" data-tooltip="Reset Password" onclick="return confirm('Reset password ke default?')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endif
                                @if($user->id !== Auth::id())
                                    @if(!$user->isSuperAdmin())
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs custom-tooltip" data-tooltip="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        margin: 0 2px;
    }

    /* Custom White Tooltip (Top) */
    .custom-tooltip {
        position: relative;
    }
    .custom-tooltip::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        color: #333;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s ease-in-out;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border: 1px solid #e0e0e0;
        z-index: 10;
    }
    .custom-tooltip::after {
        content: "";
        position: absolute;
        bottom: 105%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: #fff transparent transparent transparent;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s ease-in-out;
        z-index: 10;
    }
    .custom-tooltip:hover::before,
    .custom-tooltip:hover::after {
        opacity: 1;
    }
</style>
@endsection