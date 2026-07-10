

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
unset($__errorArgs, $__bag); ?>" id="tanggal_kejadian" name="tanggal_kejadian" value="<?php echo e(old('tanggal_kejadian', $aspirasi->tanggal_kejadian->format('Y-m-d'))); ?>" required>
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
unset($__errorArgs, $__bag); ?>" id="jam_kejadian" name="jam_kejadian" value="<?php echo e(old('jam_kejadian', $aspirasi->jam_kejadian->format('H:i'))); ?>" required>
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

            <div class="row mb-3">
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
                            <option value="<?php echo e($val); ?>" <?php echo e(old('jenis', $aspirasi->jenis) === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(old('jenis', $aspirasi->jenis) === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
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
                <div class="col-md-6" id="kategori-container">
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
                            <option value="<?php echo e($val); ?>" <?php echo e(old('kategori', $aspirasi->kategori) === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(old('kategori', $aspirasi->kategori) === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
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

            <div class="row mb-3">
                <div class="col-md-6 d-none" id="wrapper-jenis-custom">
                    <label for="jenis_custom" class="form-label">Jenis custom *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['jenis_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="jenis_custom" name="jenis_custom" value="<?php echo e(old('jenis_custom', $aspirasi->jenis_custom)); ?>">
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
                    <label for="kategori_custom" class="form-label">Kategori custom *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['kategori_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kategori_custom" name="kategori_custom" value="<?php echo e(old('kategori_custom', $aspirasi->kategori_custom)); ?>">
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

            <div class="row mb-3">
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
                            <option value="<?php echo e($item->id); ?>" <?php echo e(old('layanan_id', $aspirasi->layanan_id) == $item->id ? 'selected' : ''); ?>><?php echo e($item->nama_layanan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(old('layanan_id', is_null($aspirasi->layanan_id) && !is_null($aspirasi->layanan_custom) ? 'custom' : '') == 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
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
                        <?php $__currentLoopData = ['Tatap Muka', 'Telepon', 'WhatsApp']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($med); ?>" <?php echo e(old('media', $aspirasi->media) === $med ? 'selected' : ''); ?>><?php echo e($med); ?></option>
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
                    <label for="layanan_custom" class="form-label">Layanan custom *</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['layanan_custom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="layanan_custom" name="layanan_custom" value="<?php echo e(old('layanan_custom', $aspirasi->layanan_custom)); ?>">
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
                        <?php $__currentLoopData = ['Baru', 'Diproses', 'Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($st); ?>" <?php echo e(old('status', $aspirasi->status) === $st ? 'selected' : ''); ?>><?php echo e($st); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
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
unset($__errorArgs, $__bag); ?>" id="isi_aspirasi" name="isi_aspirasi" rows="6" required><?php echo e(old('isi_aspirasi', $aspirasi->isi_aspirasi)); ?></textarea>
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

<?php if(Auth::user()->isAdmin() && isset($dataSIP)): ?>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list"></i> Data SIP (Saran, Informasi, Pengaduan)</h5>
                <form method="GET" action="<?php echo e(route('dashboard')); ?>" class="d-flex gap-2 align-items-center">
                    <select name="range" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <?php $__currentLoopData = ['hari_ini' => 'Hari Ini', 'minggu_ini' => 'Minggu Ini', 'bulan_ini' => 'Bulan Ini', 'tahun_ini' => 'Tahun Ini', 'semua' => 'Semua']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rVal => $rLbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($rVal); ?>" <?php echo e(request('range', 'hari_ini') == $rVal ? 'selected' : ''); ?>><?php echo e($rLbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>No. Tiket</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Isi Aspirasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dataSIP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($sip->nomor_tiket); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($sip->tanggal_kejadian)->format('d/m/Y')); ?></td>
                                <td>
                                    <?php
                                        $badges = ['saran' => 'success', 'informasi' => 'info', 'pengaduan' => 'danger'];
                                        $badgeColor = $badges[$sip->jenis] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?php echo e($badgeColor); ?>">
                                        <?php echo e($sip->jenis === 'custom' ? $sip->jenis_custom : ucfirst($sip->jenis)); ?>

                                    </span>
                                </td>
                                <td><?php echo e(Str::limit($sip->isi_aspirasi, 60)); ?></td>
                                <td>
                                    <?php
                                        $statusBadges = ['Baru' => 'bg-primary', 'Diproses' => 'bg-warning text-dark', 'Selesai' => 'bg-success'];
                                    ?>
                                    <span class="badge <?php echo e($statusBadges[$sip->status] ?? 'bg-secondary'); ?>"><?php echo e($sip->status); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenis = document.getElementById('jenis');
        const kategori = document.getElementById('kategori');
        const form = jenis.closest('form');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Logic 1: Handle Kategori bawaan (Pengaduan vs Lainnya)
        function toggleKategoriBawaan() {
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
                    kategori.dispatchEvent(new Event('change'));
                }
            }
        }

        // Logic 2: Handle Opsi Kustom Dinamis (.custom-trigger)
        document.querySelectorAll('.custom-trigger').forEach(select => {
            const targetWrapper = document.querySelector(select.dataset.target);
            if (!targetWrapper) return;
            const inputField = targetWrapper.querySelector('input');

            function toggleCustomInput() {
                if (select.value === 'custom' && !select.disabled) {
                    targetWrapper.classList.remove('d-none');
                    inputField.setAttribute('required', 'required');
                } else {
                    targetWrapper.classList.add('d-none');
                    inputField.removeAttribute('required');
                }
            }

            toggleCustomInput();

            select.addEventListener('change', function() {
                toggleCustomInput();
                if (this.value !== 'custom' || this.disabled) {
                    inputField.value = '';
                }
            });
        });

        toggleKategoriBawaan();
        jenis.addEventListener('change', toggleKategoriBawaan);

        // PERBAIKAN BUG LOADING: Kunci tombol submit dan form interaksi saat proses simpan
        form.addEventListener('submit', function(e) {
            // Ubah text tombol menjadi loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.setAttribute('disabled', 'disabled');
            
            // Biarkan kategori tetap disabled secara visual, buat elemen input hidden 
            // sesaat sebelum submit agar nilainya tetap terkirim ke Laravel tanpa mengaktifkan dropdown
            if (kategori.disabled) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'kategori';
                hiddenInput.value = '';
                form.appendChild(hiddenInput);
            } else {
                // Jika tidak disabled, buat input hidden darurat untuk menampung nilainya jika diperlukan
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'kategori';
                hiddenInput.value = kategori.value;
                form.appendChild(hiddenInput);
                kategori.removeAttribute('name'); // Hapus name select utama agar tidak bertabrakan data double
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\simaspirasi-imigrasi\resources\views/aspirasi/edit.blade.php ENDPATH**/ ?>