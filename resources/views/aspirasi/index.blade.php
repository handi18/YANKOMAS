@extends('layouts.app')

@section('title', 'Data Aspirasi')

@section('content')
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list"></i> Data Aspirasi</h5>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Aspirasi
        </a>
    </div>
    
    <div class="card-body">
        <!-- Filter Section -->
        <form method="GET" class="mb-4">
            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="filter" class="form-select form-select-sm">
                        <option value="">Semua Periode</option>
                        <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('filter') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="year" {{ request('filter') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control form-control-sm" placeholder="Dari Tanggal" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control form-control-sm" placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <select name="jenis" class="form-select form-select-sm">
                        <option value="">Semua Jenis</option>
                        <option value="saran" {{ request('jenis') === 'saran' ? 'selected' : '' }}>Saran</option>
                        <option value="masukan" {{ request('jenis') === 'masukan' ? 'selected' : '' }}>Masukan</option>
                        <option value="pengaduan" {{ request('jenis') === 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        <option value="ringan" {{ request('kategori') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="sedang" {{ request('kategori') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="berat" {{ request('kategori') === 'berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Baru" {{ request('status') === 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="layanan_id" class="form-select form-select-sm">
                        <option value="">Semua Layanan</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ request('layanan_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nomor tiket..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Export Buttons -->
        <div class="mb-3">
            <a href="{{ route('aspirasi.export-excel', request()->query()) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('aspirasi.export-pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Tiket</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Layanan</th>
                        <th>Media</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aspirasi as $item)
                        <tr>
                            <td><strong>{{ $item->nomor_tiket }}</strong></td>
                            <td>{{ $item->tanggal_kejadian->format('d/m/Y') }}</td>
                            <td>{{ $item->jam_kejadian->format('H:i') }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($item->jenis) }}</span>
                            </td>
                            <td>
                                @if($item->kategori === 'ringan')
                                    <span class="badge bg-success">{{ ucfirst($item->kategori) }}</span>
                                @elseif($item->kategori === 'sedang')
                                    <span class="badge bg-warning">{{ ucfirst($item->kategori) }}</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($item->kategori) }}</span>
                                @endif
                            </td>
                            <td>{{ $item->layanan->nama_layanan }}</td>
                            <td>{{ $item->media }}</td>
                            <td>
                                @if($item->status === 'Baru')
                                    <span class="badge bg-primary">{{ $item->status }}</span>
                                @elseif($item->status === 'Diproses')
                                    <span class="badge bg-warning">{{ $item->status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>{{ $item->petugas->nama }}</td>
                            <td>
                                <a href="{{ route('aspirasi.show', $item->id) }}" class="btn btn-info btn-xs" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::user()->isAdmin() || Auth::user()->id === $item->petugas_id)
                                    <a href="{{ route('aspirasi.edit', $item->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <form action="{{ route('aspirasi.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $aspirasi->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        margin: 0 2px;
    }
</style>
@endsection
