

<?php $__env->startSection('title', 'Edit Aspirasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Data Aspirasi - <?php echo e($aspirasi->nomor_tiket); ?></h5>
    </div>
    
    <div class="card-body">
        <form action="<?php echo e(route('aspirasi.update', $aspirasi->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="alert alert-info">
                <strong>Nomor Tiket:</strong> <?php echo e($aspirasi->nomor_tiket); ?>

            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian *</label>
                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="tanggal_kejadian" name="tanggal_kejadian" value="<?php echo e(old('tanggal_kejadian', $aspirasi->tanggal_kejadian->format('Y-m-d'))); ?>" required>
                    <?php $__errorArgs = ['tanggal_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="jam_kejadian" class="form-label">Jam Kejadian *</label>
                    <input type="time" class="form-control <?php $__errorArgs = ['jam_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="jam_kejadian" name="jam_kejadian" value="<?php echo e(old('jam_kejadian', $aspirasi->jam_kejadian->format('H:i'))); ?>" required>
                    <?php $__errorArgs = ['jam_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis" class="form-label">Jenis Aspirasi *</label>
                    <select class="form-select <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="jenis" name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="saran" <?php echo e(old('jenis', $aspirasi->jenis) === 'saran' ? 'selected' : ''); ?>>Saran</option>
                        <option value="masukan" <?php echo e(old('jenis', $aspirasi->jenis) === 'masukan' ? 'selected' : ''); ?>>Masukan</option>
                        <option value="pengaduan" <?php echo e(old('jenis', $aspirasi->jenis) === 'pengaduan' ? 'selected' : ''); ?>>Pengaduan</option>
                    </select>
                    <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kategori" name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="ringan" <?php echo e(old('kategori', $aspirasi->kategori) === 'ringan' ? 'selected' : ''); ?>>Ringan</option>
                        <option value="sedang" <?php echo e(old('kategori', $aspirasi->kategori) === 'sedang' ? 'selected' : ''); ?>>Sedang</option>
                        <option value="berat" <?php echo e(old('kategori', $aspirasi->kategori) === 'berat' ? 'selected' : ''); ?>>Berat</option>
                    </select>
                    <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label">Layanan *</label>
                    <select class="form-select <?php $__errorArgs = ['layanan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="layanan_id" name="layanan_id" required>
                        <option value="">-- Pilih Layanan --</option>
                        <?php $__currentLoopData = $layanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e(old('layanan_id', $aspirasi->layanan_id) == $item->id ? 'selected' : ''); ?>>
                                <?php echo e($item->nama_layanan); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['layanan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="media" class="form-label">Media Penerimaan *</label>
                    <select class="form-select <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="media" name="media" required>
                        <option value="">-- Pilih Media --</option>
                        <option value="Tatap Muka" <?php echo e(old('media', $aspirasi->media) === 'Tatap Muka' ? 'selected' : ''); ?>>Tatap Muka</option>
                        <option value="Telepon" <?php echo e(old('media', $aspirasi->media) === 'Telepon' ? 'selected' : ''); ?>>Telepon</option>
                        <option value="WhatsApp" <?php echo e(old('media', $aspirasi->media) === 'WhatsApp' ? 'selected' : ''); ?>>WhatsApp</option>
                    </select>
                    <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <?php if(Auth::user()->isAdmin()): ?>
                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                        <option value="Baru" <?php echo e(old('status', $aspirasi->status) === 'Baru' ? 'selected' : ''); ?>>Baru</option>
                        <option value="Diproses" <?php echo e(old('status', $aspirasi->status) === 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                        <option value="Selesai" <?php echo e(old('status', $aspirasi->status) === 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="isi_aspirasi" class="form-label">Isi Aspirasi *</label>
                <textarea class="form-control <?php $__errorArgs = ['isi_aspirasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                          id="isi_aspirasi" name="isi_aspirasi" rows="6" required><?php echo e(old('isi_aspirasi', $aspirasi->isi_aspirasi)); ?></textarea>
                <small class="text-muted">Minimal 10 karakter</small>
                <?php $__errorArgs = ['isi_aspirasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?php echo e(route('aspirasi.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\Magang\projek magang\simaspirasi-imigrasi\resources\views/aspirasi/edit.blade.php ENDPATH**/ ?>