

<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-header-custom">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i> Perbarui Profil Saya</h3>
        </div>
        
        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
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

                        <hr class="my-4">

                        <h5 class="text-secondary mb-3"><i class="fas fa-image me-2"></i> Foto Diri</h5>
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <?php if($user->foto): ?>
                                    <img id="avatar-preview" src="<?php echo e(asset($user->foto)); ?>" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                <?php else: ?>
                                    <img id="avatar-preview" src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(substr($user->nama, 0, 2))); ?>&background=003366&color=fff&size=80&bold=true" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <label for="foto" class="form-label fw-bold mb-1">Pilih Foto Profil</label>
                                <input type="file" class="form-control form-control-sm" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                                <?php if($user->foto): ?>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); if(confirm('Hapus foto profil saat ini?')) { document.getElementById('form-delete-foto').submit(); }">
                                        <i class="fas fa-trash me-1"></i> Hapus Foto Saat Ini
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-start bg-white border-top py-3">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary px-4 me-2">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary-custom text-white px-4">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
    // Fungsi JavaScript untuk mendeteksi file lokal dan memunculkan preview instan
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php if($user->foto): ?>
<form id="form-delete-foto" action="<?php echo e(route('profile.delete-foto')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php endif; ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\simaspirasi-imigrasi\resources\views/admin/profile.blade.php ENDPATH**/ ?>