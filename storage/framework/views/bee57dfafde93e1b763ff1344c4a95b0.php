

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card today">
            <h5><i class="fas fa-envelope"></i> Total SIP</h5>
            <div class="value"><?php echo e($sipTotal); ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card week">
            <h5><i class="fas fa-lightbulb"></i> Saran</h5>
            <div class="value"><?php echo e($Saran); ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card month">
            <h5><i class="fas fa-info-circle"></i> Informasi</h5>
            <div class="value"><?php echo e($Informasi); ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card year">
            <h5><i class="fas fa-exclamation-circle"></i> Pengaduan</h5>
            <div class="value"><?php echo e($Pengaduan); ?></div>
        </div>
    </div>
    
    
    <div class="row mb-3">  
        <div class="col-12 d-flex align-items-center gap-2">
                <form method="GET" action="<?php echo e(route('dashboard')); ?>">
                    <select name="range" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="hari_ini"   <?php echo e(request('range') == 'hari_ini'   ? 'selected' : ''); ?>>Hari Ini</option>
                        <option value="minggu_ini" <?php echo e(request('range') == 'minggu_ini' ? 'selected' : ''); ?>>Minggu Ini</option>
                        <option value="bulan_ini"  <?php echo e(request('range') == 'bulan_ini'  ? 'selected' : ''); ?>>Bulan Ini</option>
                        <option value="tahun_ini"  <?php echo e(request('range') == 'tahun_ini'  ? 'selected' : ''); ?>>Tahun Ini</option>
                        <option value="semua"      <?php echo e(request('range', 'semua') == 'semua' ? 'selected' : ''); ?>>Semua</option>
                    </select>
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
                <h5 class="mb-0"><i class="fas fa-line-chart"></i> Tren Aspirasi (<?php echo e(now()->translatedFormat('F Y')); ?>)</h5>
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
                            <h3 class="text-primary"><?php echo e($statusBaru); ?></h3>
                            <p class="text-muted mb-0">Baru</p>
                        </div>
                        <div class="col-4">
                            <h3 class="text-warning"><?php echo e($statusDiproses); ?></h3>
                            <p class="text-muted mb-0">Diproses</p>
                        </div>
                        <div class="col-4">
                            <h3 class="text-success"><?php echo e($statusSelesai); ?></h3>
                            <p class="text-muted mb-0">Selesai</p>
                        </div>
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
            labels: ['Saran', 'Informasi', 'Pengaduan'],
            datasets: [{
                data: [<?php echo e($jenisSaran); ?>, <?php echo e($Informasi); ?>, <?php echo e($jenisPengaduan); ?>],
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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\Magang\projek magang\simaspirasi-imigrasi\resources\views/dashboard/index.blade.php ENDPATH**/ ?>