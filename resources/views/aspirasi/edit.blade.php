@extends('layouts.app')

@section('title', 'Edit Aspirasi')

@section('content')
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Data Aspirasi - {{ $aspirasi->nomor_tiket }}</h5>
    </div>
    
    <div class="card-body">
        <form action="{{ route('aspirasi.update', $aspirasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="alert alert-info">
                <strong>Nomor Tiket:</strong> {{ $aspirasi->nomor_tiket }}
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian *</label>
                    <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $aspirasi->tanggal_kejadian->format('Y-m-d')) }}" required>
                    @error('tanggal_kejadian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="jam_kejadian" class="form-label">Jam Kejadian *</label>
                    <input type="time" class="form-control @error('jam_kejadian') is-invalid @enderror" id="jam_kejadian" name="jam_kejadian" value="{{ old('jam_kejadian', $aspirasi->jam_kejadian->format('H:i')) }}" required>
                    @error('jam_kejadian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis" class="form-label">Jenis Aspirasi *</label>
                    <select class="form-select custom-trigger @error('jenis') is-invalid @enderror" id="jenis" name="jenis" data-target="#wrapper-jenis-custom" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach(['saran' => 'Saran', 'informasi' => 'Informasi', 'pengaduan' => 'Pengaduan'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('jenis', $aspirasi->jenis) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                        <option value="custom" {{ old('jenis', $aspirasi->jenis) === 'custom' ? 'selected' : '' }}>Lainnya (Custom)...</option>
                    </select>
                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6" id="kategori-container">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select custom-trigger @error('kategori') is-invalid @enderror" id="kategori" name="kategori" data-target="#wrapper-kategori-custom">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('kategori', $aspirasi->kategori) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                        <option value="custom" {{ old('kategori', $aspirasi->kategori) === 'custom' ? 'selected' : '' }}>Lainnya (Custom)...</option>
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> 
            </div>

            <div class="row mb-3">
                <div class="col-md-6 d-none" id="wrapper-jenis-custom">
                    <label for="jenis_custom" class="form-label">Jenis custom *</label>
                    <input type="text" class="form-control @error('jenis_custom') is-invalid @enderror" id="jenis_custom" name="jenis_custom" value="{{ old('jenis_custom', $aspirasi->jenis_custom) }}">
                    @error('jenis_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 d-none" id="wrapper-kategori-custom">
                    <label for="kategori_custom" class="form-label">Kategori custom *</label>
                    <input type="text" class="form-control @error('kategori_custom') is-invalid @enderror" id="kategori_custom" name="kategori_custom" value="{{ old('kategori_custom', $aspirasi->kategori_custom) }}">
                    @error('kategori_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label">Layanan *</label>
                    <select class="form-select custom-trigger @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" data-target="#wrapper-layanan-custom" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id', $aspirasi->layanan_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_layanan }}</option>
                        @endforeach
                        <option value="custom" {{ old('layanan_id', is_null($aspirasi->layanan_id) && !is_null($aspirasi->layanan_custom) ? 'custom' : '') == 'custom' ? 'selected' : '' }}>Lainnya (Custom)...</option>
                    </select>
                    @error('layanan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="media" class="form-label">Media Penerimaan *</label>
                    <select class="form-select @error('media') is-invalid @enderror" id="media" name="media" required>
                        <option value="">-- Pilih Media --</option>
                        @foreach(['Tatap Muka', 'Telepon', 'WhatsApp'] as $med)
                            <option value="{{ $med }}" {{ old('media', $aspirasi->media) === $med ? 'selected' : '' }}>{{ $med }}</option>
                        @endforeach
                    </select>
                    @error('media') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3 d-none" id="wrapper-layanan-custom">
                <div class="col-md-6">
                    <label for="layanan_custom" class="form-label">Layanan custom *</label>
                    <input type="text" class="form-control @error('layanan_custom') is-invalid @enderror" id="layanan_custom" name="layanan_custom" value="{{ old('layanan_custom', $aspirasi->layanan_custom) }}">
                    @error('layanan_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            @if(Auth::user()->isAdmin())
                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        @foreach(['Baru', 'Diproses', 'Selesai'] as $st)
                            <option value="{{ $st }}" {{ old('status', $aspirasi->status) === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endif

            <div class="mb-3">
                <label for="isi_aspirasi" class="form-label">Isi Aspirasi *</label>
                <textarea class="form-control @error('isi_aspirasi') is-invalid @enderror" id="isi_aspirasi" name="isi_aspirasi" rows="6" required>{{ old('isi_aspirasi', $aspirasi->isi_aspirasi) }}</textarea>
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

@if(Auth::user()->isAdmin() && isset($dataSIP))
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list"></i> Data SIP (Saran, Informasi, Pengaduan)</h5>
                <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2 align-items-center">
                    <select name="range" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        @foreach(['hari_ini' => 'Hari Ini', 'minggu_ini' => 'Minggu Ini', 'bulan_ini' => 'Bulan Ini', 'tahun_ini' => 'Tahun Ini', 'semua' => 'Semua'] as $rVal => $rLbl)
                            <option value="{{ $rVal }}" {{ request('range', 'hari_ini') == $rVal ? 'selected' : '' }}>{{ $rLbl }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>No. Tiket</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Isi Aspirasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataSIP as $index => $sip)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sip->nomor_tiket }}</td>
                                <td>{{ \Carbon\Carbon::parse($sip->tanggal_kejadian)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $badges = ['saran' => 'success', 'informasi' => 'info', 'pengaduan' => 'danger'];
                                        $badgeColor = $badges[$sip->jenis] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">
                                        {{ $sip->jenis === 'custom' ? $sip->jenis_custom : ucfirst($sip->jenis) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($sip->isi_aspirasi, 60) }}</td>
                                <td>
                                    @php
                                        $statusBadges = ['Baru' => 'bg-primary', 'Diproses' => 'bg-warning text-dark', 'Selesai' => 'bg-success'];
                                    @endphp
                                    <span class="badge {{ $statusBadges[$sip->status] ?? 'bg-secondary' }}">{{ $sip->status }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenis = document.getElementById('jenis');
        const kategori = document.getElementById('kategori');
        const form = jenis.closest('form');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Logic 1: Handle Kategori bawaan (Pengaduan vs Lainnya)
        function toggleKategoriBawaan() {
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
                    kategori.dispatchEvent(new Event('change'));
                }
            }
        }

        // Logic 2: Handle Opsi Kustom Dinamis (.custom-trigger)
        document.querySelectorAll('.custom-trigger').forEach(select => {
            const targetWrapper = document.querySelector(select.dataset.target);
            if (!targetWrapper) return;
            const inputField = targetWrapper.querySelector('input');

            function toggleCustomInput() {
                if (select.value === 'custom' && !select.disabled) {
                    targetWrapper.classList.remove('d-none');
                    inputField.setAttribute('required', 'required');
                } else {
                    targetWrapper.classList.add('d-none');
                    inputField.removeAttribute('required');
                }
            }

            toggleCustomInput();

            select.addEventListener('change', function() {
                toggleCustomInput();
                if (this.value !== 'custom' || this.disabled) {
                    inputField.value = '';
                }
            });
        });

        toggleKategoriBawaan();
        jenis.addEventListener('change', toggleKategoriBawaan);

        // PERBAIKAN BUG LOADING: Kunci tombol submit dan form interaksi saat proses simpan
        form.addEventListener('submit', function(e) {
            // Ubah text tombol menjadi loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.setAttribute('disabled', 'disabled');
            
            // Biarkan kategori tetap disabled secara visual, buat elemen input hidden 
            // sesaat sebelum submit agar nilainya tetap terkirim ke Laravel tanpa mengaktifkan dropdown
            if (kategori.disabled) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'kategori';
                hiddenInput.value = '';
                form.appendChild(hiddenInput);
            } else {
                // Jika tidak disabled, buat input hidden darurat untuk menampung nilainya jika diperlukan
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'kategori';
                hiddenInput.value = kategori.value;
                form.appendChild(hiddenInput);
                kategori.removeAttribute('name'); // Hapus name select utama agar tidak bertabrakan data double
            }
        });
    });
</script>
@endsection