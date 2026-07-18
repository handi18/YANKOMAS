

<?php $__env->startSection('title', 'Detail Aspirasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-eye"></i> Detail Aspirasi: <?php echo e($aspirasi->nomor_tiket); ?></h5>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 25%; background-color: #f8f9fa;">Nomor Tiket</th>
                    <td><strong><?php echo e($aspirasi->nomor_tiket); ?></strong></td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Nama Pengadu</th>
                    <td><?php echo e($aspirasi->nama_pengadu); ?></td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">No. Telepon / WhatsApp</th>
                    <td><?php echo e($aspirasi->no_telp ?? '-'); ?></td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Tanggal & Jam Kejadian</th>
                    <td>
                        <?php echo e($aspirasi->tanggal_kejadian->format('d/m/Y')); ?> 
                        Pukul <?php echo e($aspirasi->jam_kejadian ? $aspirasi->jam_kejadian->format('H:i') : '-'); ?> WIB
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Jenis Aspirasi</th>
                    <td>
                        <span class="badge bg-info">
                            <?php echo e($aspirasi->jenis === 'custom' ? $aspirasi->jenis_custom : ucfirst($aspirasi->jenis)); ?>

                        </span>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Kategori</th>
                    <td>
                        <?php if($aspirasi->kategori === 'custom'): ?>
                            <span class="badge bg-secondary"><?php echo e($aspirasi->kategori_custom); ?></span>
                        <?php elseif($aspirasi->kategori): ?>
                            <?php
                                $kategoriBadges = ['ringan' => 'bg-success', 'sedang' => 'bg-warning', 'berat' => 'bg-danger'];
                            ?>
                            <span class="badge <?php echo e($kategoriBadges[$aspirasi->kategori] ?? 'bg-secondary'); ?>"><?php echo e(ucfirst($aspirasi->kategori)); ?></span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Layanan Terkait</th>
                    <td>
                        <?php echo e(is_null($aspirasi->layanan_id) ? ($aspirasi->layanan_custom ?? '-') : ($aspirasi->layanan->nama_layanan ?? '-')); ?>

                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Media Pengaduan</th>
                    <td><?php echo e($aspirasi->media); ?></td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Status Saat Ini</th>
                    <td>
                        <?php
                            $statusBadges = ['Baru' => 'bg-primary', 'Diproses' => 'bg-warning text-dark', 'Selesai' => 'bg-success'];
                        ?>
                        <span class="badge <?php echo e($statusBadges[$aspirasi->status] ?? 'bg-secondary'); ?>"><?php echo e($aspirasi->status); ?></span>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Petugas Penginput</th>
                    <td><?php echo e($aspirasi->petugas->nama ?? '-'); ?></td>
                </tr>
                <tr>
                    <th style="background-color: #f8f9fa;">Isi Aspirasi</th>
                    <td>
                        <div class="p-3 bg-light rounded" style="white-space: pre-wrap;"><?php echo e($aspirasi->isi_aspirasi); ?></div>
                    </td>
                </tr>
            </table>
        </div>

        
        <div class="mt-4 d-flex flex-wrap align-items-center gap-3">
            
            
            <?php if(Auth::user()->isAdmin() || Auth::id() === $aspirasi->petugas_id): ?>
                <a href="<?php echo e(route('aspirasi.edit', $aspirasi->id)); ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            <?php endif; ?>

            
            <?php if(Auth::user()->isAdmin() || Auth::id() === $aspirasi->petugas_id): ?>
                <?php
                    $bgClass = 'bg-primary text-white';
                    if ($aspirasi->status === 'Diproses') $bgClass = 'bg-warning text-dark';
                    if ($aspirasi->status === 'Selesai') $bgClass = 'bg-success text-white';
                ?>

                <form action="<?php echo e(route('aspirasi.update-status', $aspirasi->id)); ?>" method="POST" class="d-flex align-items-center gap-2">
                    <?php echo csrf_field(); ?>
                    <select name="status" id="statusDropdown" class="form-select form-select-sm fw-bold <?php echo e($bgClass); ?>" style="width: 140px;" 
                        onchange="updateDropdownColor(this); this.form.submit()">
                        <option value="Baru" class="bg-white text-dark" <?php echo e($aspirasi->status == 'Baru' ? 'selected' : ''); ?>>Baru</option>
                        <option value="Diproses" class="bg-white text-dark" <?php echo e($aspirasi->status == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                        <option value="Selesai" class="bg-white text-dark" <?php echo e($aspirasi->status == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
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
            <?php endif; ?>

            
            <?php if(is_null($aspirasi->petugas_id) && Auth::user()->isPetugas()): ?>
                <form action="<?php echo e(route('aspirasi.claim', $aspirasi->id)); ?>" method="POST" onsubmit="return confirm('Anda yakin ingin mengambil alih laporan ini? Laporan ini akan dipindahkan ke Data Saya.')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
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
            <?php endif; ?>

            
            <?php if(Auth::user()->isAdmin()): ?>
                <form action="<?php echo e(route('admin.aspirasi.assign', $aspirasi->id)); ?>" method="POST" class="d-flex align-items-center gap-2">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select name="petugas_id" class="form-select" onchange="this.form.submit()" required>
                            <option value="">-- Tugaskan Petugas --</option>
                            <?php $__currentLoopData = $petugasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($petugas->id); ?>" <?php echo e($aspirasi->petugas_id == $petugas->id ? 'selected' : ''); ?>>
                                    <?php echo e($petugas->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </form>
            <?php endif; ?>

            
            <?php if(Auth::user()->isAdmin()): ?>
                <form action="<?php echo e(route('aspirasi.destroy', $aspirasi->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            <?php endif; ?>

            
            <a href="<?php echo e(url()->previous() === url()->current() ? route('aspirasi.index') : url()->previous()); ?>" class="btn btn-secondary ms-auto">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\simaspirasi-imigrasi\resources\views/aspirasi/show.blade.php ENDPATH**/ ?>