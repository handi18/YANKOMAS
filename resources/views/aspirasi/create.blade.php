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
                    <select class="form-select custom-trigger @error('jenis') is-invalid @enderror" id="jenis" name="jenis" data-target="#wrapper-jenis-custom" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach(['saran' => 'Saran', 'informasi' => 'Informasi', 'pengaduan' => 'Pengaduan'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('jenis') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                        <option value="custom" {{ old('jenis') === 'custom' ? 'selected' : '' }}>Lainnya (Custom)...</option>
                    </select>
                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select custom-trigger @error('kategori') is-invalid @enderror" id="kategori" name="kategori" data-target="#wrapper-kategori-custom">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('kategori') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                        <option value="custom" {{ old('kategori') === 'custom' ? 'selected' : '' }}>Lainnya (Custom)...</option>
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> 
            </div>

            <div class="row mb-3">
                <div class="col-md-6 d-none" id="wrapper-jenis-custom">
                    <label for="jenis_custom" class="form-label">Jenis Kustom *</label>
                    <input type="text" class="form-control @error('jenis_custom') is-invalid @enderror" id="jenis_custom" name="jenis_custom" value="{{ old('jenis_custom') }}">
                    @error('jenis_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 d-none" id="wrapper-kategori-custom">
                    <label for="kategori_custom" class="form-label">Kategori Kustom *</label>
                    <input type="text" class="form-control @error('kategori_custom') is-invalid @enderror" id="kategori_custom" name="kategori_custom" value="{{ old('kategori_custom') }}">
                    @error('kategori_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label">Layanan *</label>
                    <select class="form-select custom-trigger @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" data-target="#wrapper-layanan-custom" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_layanan }}</option>
                        @endforeach
                        <option value="custom" {{ old('layanan_id') === 'custom' ? 'selected' : '' }}>Lainnya (Custom)...</option>
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

            <div class="row mb-3 d-none" id="wrapper-layanan-custom">
                <div class="col-md-6">
                    <label for="layanan_custom" class="form-label">Layanan Kustom *</label>
                    <input type="text" class="form-control @error('layanan_custom') is-invalid @enderror" id="layanan_custom" name="layanan_custom" value="{{ old('layanan_custom') }}">
                    @error('layanan_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

        // Logic 1: Toggle Kategori bawaan sistem (Pengaduan vs Non-Pengaduan)
        function toggleKategoriBawaan() {
            // Jika jenis pilih 'custom', kita bebaskan kategori agar bisa dipilih/kustom juga
            const isPengaduan = jenis.value === 'pengaduan';
            const isCustom = jenis.value === 'custom';
            
            if (isCustom) {
                kategori.disabled = false;
                kategori.required = false;
            } else {
                kategori.disabled = !isPengaduan;
                kategori.required = isPengaduan;
                if (!isPengaduan) {
                    kategori.value = '';
                    // Trigger event change manual agar input kustom kategori ikut tersembunyi
                    kategori.dispatchEvent(new Event('change'));
                }
            }
        }

        // Logic 2: Handle Opsi Kustom Dinamis untuk Semua Dropdown bertanda .custom-trigger
        document.querySelectorAll('.custom-trigger').forEach(select => {
            const targetWrapper = document.querySelector(select.dataset.target);
            if (!targetWrapper) return;
            const inputField = targetWrapper.querySelector('input');

            function toggleCustomInput() {
                // Input kustom hanya wajib diisi jika dropdown bernilai 'custom' DAN dropdown tersebut sedang tidak disabled
                if (select.value === 'custom' && !select.disabled) {
                    targetWrapper.classList.remove('d-none');
                    inputField.setAttribute('required', 'required');
                } else {
                    targetWrapper.classList.add('d-none');
                    inputField.removeAttribute('required');
                }
            }

            // Inisialisasi awal saat halaman diload (berguna jika ada old value)
            toggleCustomInput();

            select.addEventListener('change', function() {
                toggleCustomInput();
                if (this.value !== 'custom' || this.disabled) {
                    inputField.value = ''; // Reset nilai input kustom jika batal pilih
                }
            });
        });

        // Hubungkan event listener jenis untuk trigger logika kategori bawaan
        toggleKategoriBawaan();
        jenis.addEventListener('change', toggleKategoriBawaan);
    });
</script>
@endsection