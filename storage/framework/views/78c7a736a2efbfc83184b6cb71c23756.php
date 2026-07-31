

<?php $__env->startSection('title', 'Tambah Aspirasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom">
        <h5 class="mb-0"><i class="fas fa-plus"></i> Tambah Data Aspirasi</h5>
    </div>
    
    <div class="card-body">
        <form action="<?php echo e(route('aspirasi.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nama_pengadu" class="form-label">Nama Pengadu *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['nama_pengadu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nama_pengadu" name="nama_pengadu" value="<?php echo e(old('nama_pengadu')); ?>" required>
                    <?php $__errorArgs = ['nama_pengadu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="no_telp" class="form-label">No. Telp (Opsional)</label>
                    <input type="tel" class="form-control <?php $__errorArgs = ['no_telp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="no_telp" name="no_telp" value="<?php echo e(old('no_telp')); ?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <?php $__errorArgs = ['no_telp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian *</label>
                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tanggal_kejadian" name="tanggal_kejadian" value="<?php echo e(old('tanggal_kejadian', now()->format('Y-m-d'))); ?>" required>
                    <?php $__errorArgs = ['tanggal_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
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
unset($__errorArgs, $__bag); ?>" id="jam_kejadian" name="jam_kejadian" value="<?php echo e(old('jam_kejadian', now()->format('H:i'))); ?>" required>
                    <?php $__errorArgs = ['jam_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="jenis" class="form-label">Jenis Aspirasi *</label>
                    <select class="form-select custom-trigger <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="jenis" name="jenis" data-target="#wrapper-jenis-custom" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php $__currentLoopData = ['saran' => 'Saran', 'informasi' => 'Informasi', 'pengaduan' => 'Pengaduan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('jenis') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(old('jenis') === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
                    </select>
                    <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select custom-trigger <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kategori" name="kategori" data-target="#wrapper-kategori-custom">
                        <option value="">-- Pilih Kategori --</option>
                        <?php $__currentLoopData = ['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('kategori') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(old('kategori') === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
                    </select>
                    <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div> 
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6 d-none" id="wrapper-jenis-custom">
                    <label for="jenis_custom" class="form-label">Jenis Kustom *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['jenis_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="jenis_custom" name="jenis_custom" value="<?php echo e(old('jenis_custom')); ?>">
                    <?php $__errorArgs = ['jenis_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6 d-none" id="wrapper-kategori-custom">
                    <label for="kategori_custom" class="form-label">Kategori Kustom *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['kategori_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kategori_custom" name="kategori_custom" value="<?php echo e(old('kategori_custom')); ?>">
                    <?php $__errorArgs = ['kategori_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label">Layanan *</label>
                    <select class="form-select custom-trigger <?php $__errorArgs = ['layanan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="layanan_id" name="layanan_id" data-target="#wrapper-layanan-custom" required>
                        <option value="">-- Pilih Layanan --</option>
                        <?php $__currentLoopData = $layanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e(old('layanan_id') == $item->id ? 'selected' : ''); ?>><?php echo e($item->nama_layanan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(old('layanan_id') === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
                    </select>
                    <?php $__errorArgs = ['layanan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="col-md-6">
                    <label for="media" class="form-label">Media Penerimaan <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="media" name="media" required>
                        <option value="">-- Pilih Media --</option>
                        <?php $__currentLoopData = ['Tatap Muka', 'Telepon', 'WhatsApp', 'Web/Online']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($med); ?>" <?php echo e(old('media') === $med ? 'selected' : ''); ?>><?php echo e($med); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row mb-3 d-none" id="wrapper-layanan-custom">
                <div class="col-md-6">
                    <label for="layanan_custom" class="form-label">Layanan Kustom *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['layanan_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="layanan_custom" name="layanan_custom" value="<?php echo e(old('layanan_custom')); ?>">
                    <?php $__errorArgs = ['layanan_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="isi_aspirasi" class="form-label">Isi Aspirasi *</label>
                <textarea class="form-control <?php $__errorArgs = ['isi_aspirasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="isi_aspirasi" name="isi_aspirasi" rows="6" required><?php echo e(old('isi_aspirasi')); ?></textarea>
                <small class="text-muted">Minimal 10 karakter</small>
                <?php $__errorArgs = ['isi_aspirasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?php echo e(route('aspirasi.index')); ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header card-header-custom"><h5 class="mb-0">Panduan Pengisian</h5></div>
    <div class="card-body">
        <h6>Kategori Aspirasi:</h6>
        <ul>
            <li><strong>Ringan:</strong> Kritik fasilitas kecil, Saran peningkatan pelayanan, Informasi kurang jelas, Keluhan antrean singkat</li>
            <li><strong>Sedang:</strong> Pelayanan terlambat, Petugas kurang responsif, Kesalahan administrasi ringan, Keluhan berulang</li>
            <li><strong>Berat:</strong> Dugaan pungli, Diskriminasi, Pelanggaran kode etik, Ancaman keamanan, Kasus yang memerlukan tindak lanjut pimpinan</li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenis = document.getElementById('jenis');
        const kategori = document.getElementById('kategori');

        // Logic 1: Toggle Kategori bawaan sistem (Pengaduan vs Non-Pengaduan)
        function toggleKategoriBawaan() {
            // Jika jenis pilih 'custom', kita bebaskan kategori agar bisa dipilih/kustom juga
            const isPengaduan = jenis.value === 'pengaduan';
            const isCustom = jenis.value === 'custom';
            
            if (isCustom) {
                kategori.disabled = false;
                kategori.required = false;
            } else {
                kategori.disabled = !isPengaduan;
                kategori.required = isPengaduan;
                if (!isPengaduan) {
                    kategori.value = '';
                    // Trigger event change manual agar input kustom kategori ikut tersembunyi
                    kategori.dispatchEvent(new Event('change'));
                }
            }
        }

        // Logic 2: Handle Opsi Kustom Dinamis untuk Semua Dropdown bertanda .custom-trigger
        document.querySelectorAll('.custom-trigger').forEach(select => {
            const targetWrapper = document.querySelector(select.dataset.target);
            if (!targetWrapper) return;
            const inputField = targetWrapper.querySelector('input');

            function toggleCustomInput() {
                // Input kustom hanya wajib diisi jika dropdown bernilai 'custom' DAN dropdown tersebut sedang tidak disabled
                if (select.value === 'custom' && !select.disabled) {
                    targetWrapper.classList.remove('d-none');
                    inputField.setAttribute('required', 'required');
                } else {
                    targetWrapper.classList.add('d-none');
                    inputField.removeAttribute('required');
                }
            }

            // Inisialisasi awal saat halaman diload (berguna jika ada old value)
            toggleCustomInput();

            select.addEventListener('change', function() {
                toggleCustomInput();
                if (this.value !== 'custom' || this.disabled) {
                    inputField.value = ''; // Reset nilai input kustom jika batal pilih
                }
            });
        });

        // Hubungkan event listener jenis untuk trigger logika kategori bawaan
        toggleKategoriBawaan();
        jenis.addEventListener('change', toggleKategoriBawaan);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\YANKOMAS\resources\views/aspirasi/create.blade.php ENDPATH**/ ?>