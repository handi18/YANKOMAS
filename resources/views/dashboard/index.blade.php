@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .btn-gradient-custom {
        background: linear-gradient(135deg, #0e3b75 40%);
        border: none;
        transition: filter 0.3s ease;
    }
    .btn-gradient-custom:hover {
        filter: brightness(1.2);
        color: #ffffff;
    }
</style>

{{-- Stat Cards SIP --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card today">
            <h5><i class="fas fa-envelope"></i> Total SIP</h5>
            <div class="value">{{ $sipTotal }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card week">
            <h5><i class="fas fa-lightbulb"></i> Saran</h5>
            <div class="value">{{ $Saran }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card month">
            <h5><i class="fas fa-info-circle"></i> Informasi</h5>
            <div class="value">{{ $Informasi }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card year">
            <h5><i class="fas fa-exclamation-circle"></i> Pengaduan</h5>
            <div class="value">{{ $Pengaduan }}</div>
        </div>
    </div>
    
    {{-- Filter Rentang Waktu Independen --}}
    <div class="row mb-3 mt-3">  
        <div class="col-12">
            <form method="GET" action="{{ route('dashboard') }}" class="d-flex flex-wrap align-items-center gap-3">
                
                <div class="d-flex align-items-center gap-2">
                    <select name="range" class="form-select form-select-sm" style="width: auto;" onchange="this.form.start_date.value=''; this.form.end_date.value=''; this.form.submit()">
                        <option value="semua"      {{ request('range', 'semua') == 'semua' && !request('start_date') ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="hari_ini"   {{ request('range') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu_ini" {{ request('range') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini"  {{ request('range') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini"  {{ request('range') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </div>

                <div class="vr text-muted d-none d-md-block" style="height: 30px;"></div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Rentang Custom:</span>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" required>
                    <span class="text-muted small">s.d</span>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}" required>
                    <button type="submit" class="btn btn-gradient-custom btn-sm px-3 text-white">Cari</button>
                    
                    @if(request()->filled('start_date'))
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Reset</a>
                    @endif
                </div>

            </form>
        </div>
    </div>

<div class="row mb-4">
    <div class="col-md-5">
        
        <div class="card mb-4">
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-pie-chart"></i> Grafik Jenis Aspirasi</h5>
            </div>
            <div class="card-body">
                <div style="height: 250px; position: relative;">
                    <canvas id="jenisChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card mb-4 mb-md-0"> 
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-bars"></i> Grafik Kategori</h5>
            </div>
            <div class="card-body">
                <div style="height: 250px; position: relative;">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-7">
        <div class="card h-100"> 
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-line-chart"></i> {{ $trendTitle }}</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div style="height: 570px; position: relative;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8"> 
        <div class="card">
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Status Aspirasi</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="row text-center w-100" style="max-width: 500px;"> 
                        <div class="col-4">
                            <h3 class="text-primary">{{ $statusBaru }}</h3>
                            <p class="text-muted mb-0">Baru</p>
                        </div>
                        <div class="col-4">
                            <h3 class="text-warning">{{ $statusDiproses }}</h3>
                            <p class="text-muted mb-0">Diproses</p>
                        </div>
                        <div class="col-4">
                            <h3 class="text-success">{{ $statusSelesai }}</h3>
                            <p class="text-muted mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function toggleCustomRange(value) {
        const customInputs = document.getElementById('customRangeInputs');
        if (value === 'custom') {
            customInputs.classList.remove('d-none');
        } else {
            customInputs.classList.add('d-none');
            document.getElementById('rangeSelect').form.submit();
        }
    }

    // Jenis Aspirasi Chart
    const jenisCtx = document.getElementById('jenisChart').getContext('2d');
    new Chart(jenisCtx, {
        type: 'doughnut',
        data: {
            labels: ['Informasi', 'Saran', 'Pengaduan'],
            datasets: [{
                data: [{{ $Informasi }}, {{ $jenisSaran }}, {{ $jenisPengaduan }}],
                backgroundColor: [
                    'rgba(67, 172, 188, 0.8)',  
                    'rgba(255, 193, 7, 0.8)',   
                    'rgba(220, 53, 69, 0.8)'    
                ],
                borderColor: [
                    'rgba(23, 162, 184, 1)',    
                    'rgba(255, 193, 7, 1)',     
                    'rgba(220, 53, 69, 1)'      
                ],
                borderWidth: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Kategori Chart
    const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
    new Chart(kategoriCtx, {
        type: 'bar',
        data: {
            labels: ['Ringan', 'Sedang', 'Berat'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $kategoriRingan }}, {{ $kategoriSedang }}, {{ $kategoriBerat }}],
                backgroundColor: [
                    '#43acbcff', 
                    '#ffc107', 
                    '#dc3545'  
                ],
                borderColor: [
                    '#17a2b8',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Trend Chart
    const trendData = {!! $trendData !!};
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.map(d => d.date),
            datasets: [{
                label: 'Jumlah Aspirasi',
                data: trendData.map(d => d.count),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush