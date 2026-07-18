@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-eye"></i> Detail Aspirasi: {{ $aspirasi->nomor_tiket }}</h5>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 25%; background-color: #f8f9fa;">Nomor Tiket</th>
                    <td><strong>{{ $aspirasi->nomor_tiket }}</strong></td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Nama Pengadu</th>
                    <td>{{ $aspirasi->nama_pengadu }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">No. Telepon / WhatsApp</th>
                    <td>{{ $aspirasi->no_telp ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Tanggal & Jam Kejadian</th>
                    <td>
                        {{ $aspirasi->tanggal_kejadian->format('d/m/Y') }} 
                        Pukul {{ $aspirasi->jam_kejadian ? $aspirasi->jam_kejadian->format('H:i') : '-' }} WIB
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Jenis Aspirasi</th>
                    <td>
                        <span class="badge bg-info">
                            {{ $aspirasi->jenis === 'custom' ? $aspirasi->jenis_custom : ucfirst($aspirasi->jenis) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Kategori</th>
                    <td>
                        @if($aspirasi->kategori === 'custom')
                            <span class="badge bg-secondary">{{ $aspirasi->kategori_custom }}</span>
                        @elseif($aspirasi->kategori)
                            @php
                                $kategoriBadges = ['ringan' => 'bg-success', 'sedang' => 'bg-warning', 'berat' => 'bg-danger'];
                            @endphp
                            <span class="badge {{ $kategoriBadges[$aspirasi->kategori] ?? 'bg-secondary' }}">{{ ucfirst($aspirasi->kategori) }}</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Layanan Terkait</th>
                    <td>
                        {{ is_null($aspirasi->layanan_id) ? ($aspirasi->layanan_custom ?? '-') : ($aspirasi->layanan->nama_layanan ?? '-') }}
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Media Pengaduan</th>
                    <td>{{ $aspirasi->media }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Status Saat Ini</th>
                    <td>
                        @php
                            $statusBadges = ['Baru' => 'bg-primary', 'Diproses' => 'bg-warning text-dark', 'Selesai' => 'bg-success'];
                        @endphp
                        <span class="badge {{ $statusBadges[$aspirasi->status] ?? 'bg-secondary' }}">{{ $aspirasi->status }}</span>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Petugas Penginput</th>
                    <td>{{ $aspirasi->petugas->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Isi Aspirasi</th>
                    <td>
                        <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $aspirasi->isi_aspirasi }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Section Aksi/Tombol Bawah --}}
        <div class="mt-4 d-flex flex-wrap align-items-center gap-3">
            
            {{-- 1. Tombol Edit (Hanya jika Admin atau Pemilik Data) --}}
            @if(Auth::user()->isAdmin() || Auth::id() === $aspirasi->petugas_id)
                <a href="{{ route('aspirasi.edit', $aspirasi->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            @endif

            {{-- 2. Fitur Update Status Langsung (Dropdown Inline Form Bermutasi Warna) --}}
            @if(Auth::user()->isAdmin() || Auth::id() === $aspirasi->petugas_id)
                @php
                    $bgClass = 'bg-primary text-white';
                    if ($aspirasi->status === 'Diproses') $bgClass = 'bg-warning text-dark';
                    if ($aspirasi->status === 'Selesai') $bgClass = 'bg-success text-white';
                @endphp

                <form action="{{ route('aspirasi.update-status', $aspirasi->id) }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <select name="status" id="statusDropdown" class="form-select form-select-sm fw-bold {{ $bgClass }}" style="width: 140px;" 
                        onchange="updateDropdownColor(this); this.form.submit()">
                        <option value="Baru" class="bg-white text-dark" {{ $aspirasi->status == 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Diproses" class="bg-white text-dark" {{ $aspirasi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" class="bg-white text-dark" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>

                <script>
                function updateDropdownColor(el) {
                    el.classList.remove('bg-primary', 'bg-warning', 'bg-success', 'text-white', 'text-dark');
                    if (el.value === 'Baru') {
                        el.classList.add('bg-primary', 'text-white');
                    } else if (el.value === 'Diproses') {
                        el.classList.add('bg-warning', 'text-dark');
                    } else if (el.value === 'Selesai') {
                        el.classList.add('bg-success', 'text-white');
                    }
                }
                </script>
            @endif

            {{-- 3. Fitur Ambil Alih Laporan / Claim (Kolam Bersama untuk Petugas) --}}
            @if(is_null($aspirasi->petugas_id) && Auth::user()->isPetugas())
                <form action="{{ route('aspirasi.claim', $aspirasi->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengambil alih laporan ini? Laporan ini akan dipindahkan ke Data Saya.')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-lg btn-success pulse-animation fw-bold">
                        <i class="fas fa-hand-paper"></i> Ambil Alih Laporan Ini
                    </button>
                </form>
                
                <style>
                    .pulse-animation {
                        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
                        animation: pulse 2s infinite;
                    }
                    @keyframes pulse {
                        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
                        70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
                    }
                </style>
            @endif

            {{-- 4. Fitur Assign/Re-assign Petugas (Hanya Admin) --}}
            @if(Auth::user()->isAdmin())
                <form action="{{ route('admin.aspirasi.assign', $aspirasi->id) }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    @method('PUT')
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select name="petugas_id" class="form-select" onchange="this.form.submit()" required>
                            <option value="">-- Tugaskan Petugas --</option>
                            @foreach($petugasList as $petugas)
                                <option value="{{ $petugas->id }}" {{ $aspirasi->petugas_id == $petugas->id ? 'selected' : '' }}>
                                    {{ $petugas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            @endif

            {{-- 5. Tombol Hapus (Hanya Admin) --}}
            @if(Auth::user()->isAdmin())
                <form action="{{ route('aspirasi.destroy', $aspirasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            @endif

            {{-- 6. Tombol Kembali dengan Jaring Pengaman Fallback --}}
            <a href="{{ url()->previous() === url()->current() ? route('aspirasi.index') : url()->previous() }}" class="btn btn-secondary ms-auto">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection