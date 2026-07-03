@extends('layouts.app')

@section('title', 'Tambah Aspirasi')

@section('content')
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-plus"></i> Tambah Data Aspirasi</h5>
    </div>
    
    <div class="card-body">
        <form action="{{ route('aspirasi.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama_pengadu" class="form-label">Nama Pengadu *</label>
                    <input type="text" class="form-control @error('nama_pengadu') is-invalid @enderror" id="nama_pengadu" name="nama_pengadu" value="{{ old('nama_pengadu') }}" required>
                    @error('nama_pengadu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="no_telp" class="form-label">No. Telp (Opsional)</label>
                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}">
                    @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian *</label>
                    <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', now()->format('Y-m-d')) }}" required>
                    @error('tanggal_kejadian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="jam_kejadian" class="form-label">Jam Kejadian *</label>
                    <input type="time" class="form-control @error('jam_kejadian') is-invalid @enderror" id="jam_kejadian" name="jam_kejadian" value="{{ old('jam_kejadian', now()->format('H:i')) }}" required>
                    @error('jam_kejadian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis" class="form-label">Jenis Aspirasi *</label>
                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach(['saran' => 'Saran', 'informasi' => 'Informasi', 'pengaduan' => 'Pengaduan'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('jenis') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('kategori') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> 
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label">Layanan *</label>
                    <select class="form-select @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_layanan }}</option>
                        @endforeach
                    </select>
                    @error('layanan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="media" class="form-label">Media Penerimaan *</label>
                    <select class="form-select @error('media') is-invalid @enderror" id="media" name="media" required>
                        <option value="">-- Pilih Media --</option>
                        @foreach(['Tatap Muka', 'Telepon', 'WhatsApp'] as $med)
                            <option value="{{ $med }}" {{ old('media', 'Tatap Muka') === $med ? 'selected' : '' }}>{{ $med }}</option>
                        @endforeach
                    </select>
                    @error('media') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="isi_aspirasi" class="form-label">Isi Aspirasi *</label>
                <textarea class="form-control @error('isi_aspirasi') is-invalid @enderror" id="isi_aspirasi" name="isi_aspirasi" rows="6" required>{{ old('isi_aspirasi') }}</textarea>
                <small class="text-muted">Minimal 10 karakter</small>
                @error('isi_aspirasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header card-header-custom"><h5 class="mb-0">Panduan Pengisian</h5></div>
    <div class="card-body">
        <h6>Kategori Aspirasi:</h6>
        <ul>
            <li><strong>Ringan:</strong> Kritik fasilitas kecil, Saran peningkatan pelayanan, Informasi kurang jelas, Keluhan antrean singkat</li>
            <li><strong>Sedang:</strong> Pelayanan terlambat, Petugas kurang responsif, Kesalahan administrasi ringan, Keluhan berulang</li>
            <li><strong>Berat:</strong> Dugaan pungli, Diskriminasi, Pelanggaran kode etik, Ancaman keamanan, Kasus yang memerlukan tindak lanjut pimpinan</li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenis = document.getElementById('jenis');
        const kategori = document.getElementById('kategori');

        function toggleKategori() {
            const isPengaduan = jenis.value === 'pengaduan';
            kategori.disabled = !isPengaduan;
            kategori.required = isPengaduan;
            if (!isPengaduan) kategori.value = '';
        }

        toggleKategori();
        jenis.addEventListener('change', toggleKategori);
    });
</script>
@endsection