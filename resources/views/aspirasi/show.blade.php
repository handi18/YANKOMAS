@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Detail Aspirasi - {{ $aspirasi->nomor_tiket }}</h5>
        @if(Auth::user()->isAdmin() || Auth::user()->id === $aspirasi->petugas_id)
            <a href="{{ route('aspirasi.edit', $aspirasi->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        @endif
    </div>
    
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-muted">Nomor Tiket</h6>
                <p class="font-weight-bold">{{ $aspirasi->nomor_tiket }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Petugas Penginput</h6>
                <p class="font-weight-bold">{{ $aspirasi->petugas->nama }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h6 class="text-muted">Tanggal Kejadian</h6>
                <p class="font-weight-bold">{{ $aspirasi->tanggal_kejadian->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Jam Kejadian</h6>
                <p class="font-weight-bold">{{ $aspirasi->jam_kejadian->format('H:i') }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Tanggal Input</h6>
                <p class="font-weight-bold">{{ $aspirasi->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Terakhir Diubah</h6>
                <p class="font-weight-bold">{{ $aspirasi->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h6 class="text-muted">Jenis Aspirasi</h6>
                <p><span class="badge bg-info">{{ ucfirst($aspirasi->jenis) }}</span></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Kategori</h6>
                <p>
                    @if($aspirasi->kategori === 'ringan')
                        <span class="badge bg-success">{{ ucfirst($aspirasi->kategori) }}</span>
                    @elseif($aspirasi->kategori === 'sedang')
                        <span class="badge bg-warning">{{ ucfirst($aspirasi->kategori) }}</span>
                    @else
                        <span class="badge bg-danger">{{ ucfirst($aspirasi->kategori) }}</span>
                    @endif
                </p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Media Penerimaan</h6>
                <p><strong>{{ $aspirasi->media }}</strong></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Status</h6>
                <p>
                    @if($aspirasi->status === 'Baru')
                        <span class="badge bg-primary">{{ $aspirasi->status }}</span>
                    @elseif($aspirasi->status === 'Diproses')
                        <span class="badge bg-warning">{{ $aspirasi->status }}</span>
                    @else
                        <span class="badge bg-success">{{ $aspirasi->status }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-muted">Layanan</h6>
                <p class="font-weight-bold">{{ $aspirasi->layanan->nama_layanan }}</p>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <h6 class="text-muted">Isi Aspirasi</h6>
            <div class="card bg-light">
                <div class="card-body">
                    <p>{{ $aspirasi->isi_aspirasi }}</p>
                </div>
            </div>
        </div>

        @if(Auth::user()->isAdmin() && $aspirasi->status !== 'Selesai')
            <hr>
            <h6>Ubah Status</h6>
            <form action="{{ route('aspirasi.update-status', $aspirasi->id) }}" method="POST" class="d-flex gap-2">
                @csrf
                <select name="status" class="form-select form-select-sm" style="max-width: 200px;">
                    <option value="Baru" {{ $aspirasi->status === 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Diproses" {{ $aspirasi->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $aspirasi->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-check"></i> Ubah Status
                </button>
            </form>
        @endif

        <hr>

        <div class="d-flex gap-2">
            <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if(Auth::user()->isAdmin())
                <form action="{{ route('aspirasi.destroy', $aspirasi->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
