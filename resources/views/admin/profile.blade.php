@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-header-custom">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i> Perbarui Profil Saya</h3>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-end pe-md-4">
                        <h5 class="text-secondary mb-3"><i class="fas fa-id-card me-2"></i> Data Diri</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->nip }}" readonly disabled>
                            <small class="text-muted d-block mt-1">NIP tidak dapat diubah secara mandiri.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->username }}" readonly disabled>
                            <small class="text-muted d-block mt-1">Username tidak dapat diubah secara mandiri.</small>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Kantor</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6 ps-md-4">
                        <h5 class="text-secondary mb-3"><i class="fas fa-lock me-2"></i> Ganti Password (Opsional)</h5>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end bg-white border-top py-3">
                <button type="submit" class="btn btn-primary-custom text-white px-4">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection