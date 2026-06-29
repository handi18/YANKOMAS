

<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-header-custom">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i> Perbarui Profil Saya</h3>
        </div>
        
        <form action="<?php echo e(route('profile.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-end pe-md-4">
                        <h5 class="text-secondary mb-3"><i class="fas fa-id-card me-2"></i> Data Diri</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" class="form-control bg-light" value="<?php echo e($user->nip); ?>" readonly disabled>
                            <small class="text-muted d-block mt-1">NIP tidak dapat diubah secara mandiri.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control bg-light" value="<?php echo e($user->username); ?>" readonly disabled>
                            <small class="text-muted d-block mt-1">Username tidak dapat diubah secara mandiri.</small>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo e(old('nama', $user->nama)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Kantor</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 ps-md-4">
                        <h5 class="text-secondary mb-3"><i class="fas fa-lock me-2"></i> Ganti Password (Opsional)</h5>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end bg-white border-top py-3">
                <button type="submit" class="btn btn-primary-custom text-white px-4">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\Magang\projek magang\simaspirasi-imigrasi\resources\views/admin/profile.blade.php ENDPATH**/ ?>