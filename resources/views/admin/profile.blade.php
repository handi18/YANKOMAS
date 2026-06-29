@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-header-custom">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i> Perbarui Profil Saya</h3>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
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

                        <hr class="my-4">

                        <h5 class="text-secondary mb-3"><i class="fas fa-image me-2"></i> Foto Diri</h5>
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                @if($user->foto)
                                    <img id="avatar-preview" src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode(substr($user->nama, 0, 2)) }}&background=003366&color=fff&size=80&bold=true" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <label for="foto" class="form-label fw-bold mb-1">Pilih Foto Profil</label>
                                <input type="file" class="form-control form-control-sm" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                                @if($user->foto)
                                    <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); if(confirm('Hapus foto profil saat ini?')) { document.getElementById('form-delete-foto').submit(); }">
                                        <i class="fas fa-trash me-1"></i> Hapus Foto Saat Ini
                                    </button>
                                @endif
                            </div>
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

@push('js')
<script>
    // Fungsi JavaScript untuk mendeteksi file lokal dan memunculkan preview instan
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@if($user->foto)
<form id="form-delete-foto" action="{{ route('profile.delete-foto') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif