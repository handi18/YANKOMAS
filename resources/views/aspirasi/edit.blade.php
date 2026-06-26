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
                    <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                           id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $aspirasi->tanggal_kejadian->format('Y-m-d')) }}" required>
                    @error('tanggal_kejadian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="jam_kejadian" class="form-label">Jam Kejadian *</label>
                    <input type="time" class="form-control @error('jam_kejadian') is-invalid @enderror" 
                           id="jam_kejadian" name="jam_kejadian" value="{{ old('jam_kejadian', $aspirasi->jam_kejadian->format('H:i')) }}" required>
                    @error('jam_kejadian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis" class="form-label">Jenis Aspirasi *</label>
                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="saran" {{ old('jenis', $aspirasi->jenis) === 'saran' ? 'selected' : '' }}>Saran</option>
                        <option value="informasi" {{ old('jenis', $aspirasi->jenis) === 'informasi' ? 'selected' : '' }}>Informasi</option>
                        <option value="pengaduan" {{ old('jenis', $aspirasi->jenis) === 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                    </select>
                    @error('jenis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="ringan" {{ old('kategori', $aspirasi->kategori) === 'ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="sedang" {{ old('kategori', $aspirasi->kategori) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="berat" {{ old('kategori', $aspirasi->kategori) === 'berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label">Layanan *</label>
                    <select class="form-select @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id', $aspirasi->layanan_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="media" class="form-label">Media Penerimaan *</label>
                    <select class="form-select @error('media') is-invalid @enderror" id="media" name="media" required>
                        <option value="">-- Pilih Media --</option>
                        <option value="Tatap Muka" {{ old('media', $aspirasi->media) === 'Tatap Muka' ? 'selected' : '' }}>Tatap Muka</option>
                        <option value="Telepon" {{ old('media', $aspirasi->media) === 'Telepon' ? 'selected' : '' }}>Telepon</option>
                        <option value="WhatsApp" {{ old('media', $aspirasi->media) === 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                    </select>
                    @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @if(Auth::user()->isAdmin())
                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        {{-- Filter & Tabel SIP --}}
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fas fa-list"></i> Data SIP (Saran, Informasi, Pengaduan)</h5>

                                        {{-- Filter Dropdown Range Waktu --}}
                                        <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2 align-items-center">
                                            <select name="range" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                                <option value="hari_ini"   {{ request('range','hari_ini') == 'hari_ini'   ? 'selected' : '' }}>Hari Ini</option>
                                                <option value="minggu_ini" {{ request('range') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                                                <option value="bulan_ini"  {{ request('range') == 'bulan_ini'  ? 'selected' : '' }}>Bulan Ini</option>
                                                <option value="tahun_ini"  {{ request('range') == 'tahun_ini'  ? 'selected' : '' }}>Tahun Ini</option>
                                                <option value="semua"      {{ request('range') == 'semua'      ? 'selected' : '' }}>Semua</option>
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
                                                            @if($sip->jenis == 'saran')
                                                                <span class="badge bg-success">Saran</span>
                                                            @elseif($sip->jenis == 'informasi')
                                                                <span class="badge bg-info">Informasi</span>
                                                            @elseif($sip->jenis == 'pengaduan')
                                                                <span class="badge bg-danger">Pengaduan</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ ucfirst($sip->jenis) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ Str::limit($sip->isi_aspirasi, 60) }}</td>
                                                        <td>
                                                            @if($sip->status == 'Baru')
                                                                <span class="badge bg-primary">Baru</span>
                                                            @elseif($sip->status == 'Diproses')
                                                                <span class="badge bg-warning text-dark">Diproses</span>
                                                            @elseif($sip->status == 'Selesai')
                                                                <span class="badge bg-success">Selesai</span>
                                                            @endif
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

                        <option value="Baru" {{ old('status', $aspirasi->status) === 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Diproses" {{ old('status', $aspirasi->status) === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ old('status', $aspirasi->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3">
                <label for="isi_aspirasi" class="form-label">Isi Aspirasi *</label>
                <textarea class="form-control @error('isi_aspirasi') is-invalid @enderror" 
                          id="isi_aspirasi" name="isi_aspirasi" rows="6" required>{{ old('isi_aspirasi', $aspirasi->isi_aspirasi) }}</textarea>
                <small class="text-muted">Minimal 10 karakter</small>
                @error('isi_aspirasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
