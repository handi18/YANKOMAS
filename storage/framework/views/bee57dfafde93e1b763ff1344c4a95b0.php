

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card today">
            <h5><i class="fas fa-calendar-day"></i> Hari Ini</h5>
            <div class="value"><?php echo e($today); ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card week">
            <h5><i class="fas fa-calendar-week"></i> Minggu Ini</h5>
            <div class="value"><?php echo e($thisWeek); ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card month">
            <h5><i class="fas fa-calendar-alt"></i> Bulan Ini</h5>
            <div class="value"><?php echo e($thisMonth); ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card year">
            <h5><i class="fas fa-calendar"></i> Tahun Ini</h5>
            <div class="value"><?php echo e($thisYear); ?></div>
        </div>
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

        <div class="card mb-4 mb-md-0"> <div class="card-header card-header-custom">
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
        <div class="card h-100"> <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-line-chart"></i> Tren Aspirasi (<?php echo e(now()->format('F Y')); ?>)</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div style="height: 570px; position: relative;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-trophy"></i> Layanan Top 5</h5>
            </div>
            <div class="card-body">
                <canvas id="layananChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Status Aspirasi</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3 class="text-primary"><?php echo e($statusBaru); ?></h3>
                        <p class="text-muted">Baru</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-warning"><?php echo e($statusDiproses); ?></h3>
                        <p class="text-muted">Diproses</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-success"><?php echo e($statusSelesai); ?></h3>
                        <p class="text-muted">Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
    // Jenis Aspirasi Chart
    const jenisCtx = document.getElementById('jenisChart').getContext('2d');
    new Chart(jenisCtx, {
        type: 'doughnut',
        data: {
            labels: ['Saran', 'Masukan', 'Pengaduan'],
            datasets: [{
                data: [<?php echo e($jenisSaran); ?>, <?php echo e($jenisMasukan); ?>, <?php echo e($jenisPengaduan); ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Ditambahkan agar mengikuti tinggi wrapper div
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
                data: [<?php echo e($kategoriRingan); ?>, <?php echo e($kategoriSedang); ?>, <?php echo e($kategoriBerat); ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Ditambahkan agar mengikuti tinggi wrapper div
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Trend Chart
    const trendData = <?php echo $trendData; ?>;
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.map(d => 'Hari ' + d.date),
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
            maintainAspectRatio: false, // <-- Tambahkan baris ini jika belum ada
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Top Layanan Chart
    const layananLabels = <?php echo json_encode($topLayanan->pluck('nama_layanan')->toArray()); ?>;
    const layananData = <?php echo json_encode($topLayanan->pluck('aspirasi_count')->toArray()); ?>;
    const layananCtx = document.getElementById('layananChart').getContext('2d');
    new Chart(layananCtx, {
        type: 'horizontalBar',
        data: {
            labels: layananLabels,
            datasets: [{
                label: 'Jumlah Aspirasi',
                data: layananData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\Magang\projek magang\simaspirasi-imigrasi\resources\views/dashboard/index.blade.php ENDPATH**/ ?>