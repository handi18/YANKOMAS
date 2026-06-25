

<?php $__env->startSection('title', 'Detail Aspirasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Detail Aspirasi - <?php echo e($aspirasi->nomor_tiket); ?></h5>
        <?php if(Auth::user()->isAdmin() || Auth::user()->id === $aspirasi->petugas_id): ?>
            <a href="<?php echo e(route('aspirasi.edit', $aspirasi->id)); ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        <?php endif; ?>
    </div>
    
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-muted">Nomor Tiket</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->nomor_tiket); ?></p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Petugas Penginput</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->petugas->nama); ?></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h6 class="text-muted">Tanggal Kejadian</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->tanggal_kejadian->format('d/m/Y')); ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Jam Kejadian</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->jam_kejadian->format('H:i')); ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Tanggal Input</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->created_at->format('d/m/Y H:i')); ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Terakhir Diubah</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->updated_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h6 class="text-muted">Jenis Aspirasi</h6>
                <p><span class="badge bg-info"><?php echo e(ucfirst($aspirasi->jenis)); ?></span></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Kategori</h6>
                <p>
                    <?php if($aspirasi->kategori === 'ringan'): ?>
                        <span class="badge bg-success"><?php echo e(ucfirst($aspirasi->kategori)); ?></span>
                    <?php elseif($aspirasi->kategori === 'sedang'): ?>
                        <span class="badge bg-warning"><?php echo e(ucfirst($aspirasi->kategori)); ?></span>
                    <?php else: ?>
                        <span class="badge bg-danger"><?php echo e(ucfirst($aspirasi->kategori)); ?></span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Media Penerimaan</h6>
                <p><strong><?php echo e($aspirasi->media); ?></strong></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Status</h6>
                <p>
                    <?php if($aspirasi->status === 'Baru'): ?>
                        <span class="badge bg-primary"><?php echo e($aspirasi->status); ?></span>
                    <?php elseif($aspirasi->status === 'Diproses'): ?>
                        <span class="badge bg-warning"><?php echo e($aspirasi->status); ?></span>
                    <?php else: ?>
                        <span class="badge bg-success"><?php echo e($aspirasi->status); ?></span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-muted">Layanan</h6>
                <p class="font-weight-bold"><?php echo e($aspirasi->layanan->nama_layanan); ?></p>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <h6 class="text-muted">Isi Aspirasi</h6>
            <div class="card bg-light">
                <div class="card-body">
                    <p><?php echo e($aspirasi->isi_aspirasi); ?></p>
                </div>
            </div>
        </div>

        <?php if(Auth::user()->isAdmin() && $aspirasi->status !== 'Selesai'): ?>
            <hr>
            <h6>Ubah Status</h6>
            <form action="<?php echo e(route('aspirasi.update-status', $aspirasi->id)); ?>" method="POST" class="d-flex gap-2">
                <?php echo csrf_field(); ?>
                <select name="status" class="form-select form-select-sm" style="max-width: 200px;">
                    <option value="Baru" <?php echo e($aspirasi->status === 'Baru' ? 'selected' : ''); ?>>Baru</option>
                    <option value="Diproses" <?php echo e($aspirasi->status === 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                    <option value="Selesai" <?php echo e($aspirasi->status === 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-check"></i> Ubah Status
                </button>
            </form>
        <?php endif; ?>

        <hr>

        <div class="d-flex gap-2">
            <a href="<?php echo e(route('aspirasi.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <?php if(Auth::user()->isAdmin()): ?>
                <form action="<?php echo e(route('aspirasi.destroy', $aspirasi->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\Magang\projek magang\simaspirasi-imigrasi\resources\views/aspirasi/show.blade.php ENDPATH**/ ?>