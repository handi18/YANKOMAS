@extends('layouts.app')

@section('title', 'Data Aspirasi')

@section('content')
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list"></i> Data Aspirasi</h5>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-light btn-sm"><i class="fas fa-plus"></i> Tambah Aspirasi</a>
    </div>
    
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="row mb-3 gap-2 gap-md-0">
                {{-- Filter Scope Otorisasi: Hanya Ditampilkan untuk Petugas --}}
                @if(Auth::user()->isPetugas())
                <div class="col-md-2">
                    <select name="scope" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="my_data" {{ ($current_scope ?? request('scope', 'my_data')) === 'my_data' ? 'selected' : '' }}>Data Saya</option>
                        <option value="all" {{ ($current_scope ?? request('scope', 'my_data')) === 'all' ? 'selected' : '' }}>Semua Data</option>
                    </select>
                </div>
                @endif
                
                <div class="col-md-2">
                    <select name="filter" class="form-select form-select-sm">
                        <option value="">Semua Periode</option>
                        @foreach(['today' => 'Hari Ini', 'week' => 'Minggu Ini', 'month' => 'Bulan Ini', 'year' => 'Tahun Ini'] as $val => $lbl)
                            <option value="{{ $val }}" {{ request('filter') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <select name="jenis" class="form-select form-select-sm">
                        <option value="">Semua Jenis</option>
                        @foreach(['saran' => 'Saran', 'informasi' => 'Informasi', 'pengaduan' => 'Pengaduan'] as $val => $lbl)
                            <option value="{{ $val }}" {{ request('jenis') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'] as $val => $lbl)
                            <option value="{{ $val }}" {{ request('kategori') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        @foreach(['Baru', 'Diproses', 'Selesai'] as $st)
                            <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="layanan_id" class="form-select form-select-sm">
                        <option value="">Semua Layanan</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ request('layanan_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nomor tiket..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-redo"></i> Reset</a>
                </div>
            </div>
        </form>

        <div class="mb-3">
            <a href="{{ route('aspirasi.export-excel', request()->query()) }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Excel</a>
            <a href="{{ route('aspirasi.export-pdf', request()->query()) }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Tiket / Pengadu</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aspirasi as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->nama_pengadu }}</strong>
                                <div class="small text-muted">{{ $item->nomor_tiket }}</div>
                            </td>
                            <td>{{ $item->tanggal_kejadian->format('d/m/Y') }}</td>
                            <td>{{ $item->jam_kejadian->format('H:i') }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($item->jenis) }}</span></td>
                            <td>
                                @php
                                    $kategoriBadges = ['ringan' => 'bg-success', 'sedang' => 'bg-warning', 'berat' => 'bg-danger'];
                                @endphp
                                <span class="badge {{ $kategoriBadges[$item->kategori] ?? 'bg-secondary' }}">{{ ucfirst($item->kategori) }}</span>
                            </td>
                            <td>{{ $item->layanan->nama_layanan }}</td>
                            <td>
                                @php
                                    $statusBadges = ['Baru' => 'bg-primary', 'Diproses' => 'bg-warning text-dark', 'Selesai' => 'bg-success'];
                                @endphp
                                <span class="badge {{ $statusBadges[$item->status] ?? 'bg-secondary' }}">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->petugas->nama }}</td>
                            <td>
                                {{-- Tombol Lihat Detail: Petugas hanya boleh lihat datanya sendiri (jika show diproteksi) --}}
                                @if(Auth::user()->isAdmin() || Auth::id() === $item->petugas_id)
                                    <a href="{{ route('aspirasi.show', $item->id) }}" class="btn btn-info btn-xs custom-tooltip" data-tooltip="Lihat Detail"><i class="fas fa-eye"></i></a>
                                @endif

                                {{-- Tombol Hapus: Dikunci total hanya untuk Admin/Super Admin --}}
                                @if(Auth::user()->isAdmin())
                                    <form action="{{ route('aspirasi.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs custom-tooltip" data-tooltip="Hapus Data"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $aspirasi->appends(request()->query())->links('pagination::bootstrap-5') }}
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