@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-history"></i> Log Aktivitas</h5>
    </div>
    
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nama }} ({{ $user->role }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari aktivitas..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <strong>{{ $log->user->nama }}</strong>
                                <br>
                                <small class="text-muted">{{ $log->user->username }}</small>
                            </td>
                            <td>{{ $log->aktivitas }}</td>
                            <td>
                                <small>{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
