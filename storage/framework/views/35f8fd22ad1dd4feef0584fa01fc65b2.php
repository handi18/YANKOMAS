

<?php $__env->startSection('title', 'Data Aspirasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list"></i> Data Aspirasi</h5>
        <a href="<?php echo e(route('aspirasi.create')); ?>" class="btn btn-light btn-sm"><i class="fas fa-plus"></i> Tambah Aspirasi</a>
    </div>
    
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="row mb-3 gap-2 gap-md-0">
                <div class="col-md-2">
                    <select name="scope" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php if(Auth::user()->isPetugas()): ?>
                            <option value="my_data" <?php echo e(($current_scope ?? request('scope', 'my_data')) === 'my_data' ? 'selected' : ''); ?>>Data Saya</option>
                        <?php endif; ?>
                        <option value="all" <?php echo e(($current_scope ?? request('scope', Auth::user()->isPetugas() ? 'my_data' : 'all')) === 'all' ? 'selected' : ''); ?>>Semua Data</option>
                        
                        
                        <option value="masyarakat" <?php echo e(request('scope') === 'masyarakat' ? 'selected' : ''); ?>>Data Masyarakat (Baru Masuk)</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <select name="filter" class="form-select form-select-sm">
                        <option value="">Semua Periode</option>
                        <?php $__currentLoopData = ['today' => 'Hari Ini', 'week' => 'Minggu Ini', 'month' => 'Bulan Ini', 'year' => 'Tahun Ini']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(request('filter') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e(request('date_to')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="jenis" class="form-select form-select-sm">
                        <option value="">Semua Jenis</option>
                        <?php $__currentLoopData = ['saran' => 'Saran', 'informasi' => 'Informasi', 'pengaduan' => 'Pengaduan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(request('jenis') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(request('jenis') === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = ['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(request('kategori') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(request('kategori') === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <?php $__currentLoopData = ['Baru', 'Diproses', 'Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($st); ?>" <?php echo e(request('status') === $st ? 'selected' : ''); ?>><?php echo e($st); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="layanan_id" class="form-select form-select-sm">
                        <option value="">Semua Layanan</option>
                        <?php $__currentLoopData = $layanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e(request('layanan_id') == $item->id ? 'selected' : ''); ?>><?php echo e($item->nama_layanan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="custom" <?php echo e(request('layanan_id') === 'custom' ? 'selected' : ''); ?>>Lainnya (Custom)...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nomor tiket..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                    <a href="<?php echo e(route('aspirasi.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-redo"></i> Reset</a>
                </div>
            </div>
        </form>

        <div class="mb-3">
            <a href="<?php echo e(route('aspirasi.export-excel', request()->query())); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Excel</a>
            <a href="<?php echo e(route('aspirasi.export-pdf', request()->query())); ?>" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Tiket / Pengadu</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $aspirasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($item->nama_pengadu); ?></strong>
                                <div class="small text-muted"><?php echo e($item->nomor_tiket); ?></div>
                            </td>
                            <td><?php echo e($item->tanggal_kejadian->format('d/m/Y')); ?></td>
                            <td><?php echo e($item->jam_kejadian->format('H:i')); ?></td>
                            <td><span class="badge bg-info"><?php echo e(!is_null($item->jenis_custom) ? $item->jenis_custom : ucfirst($item->jenis)); ?></span></td>
                            <td>
                                <?php
                                    $kategoriBadges = ['ringan' => 'bg-success', 'sedang' => 'bg-warning', 'berat' => 'bg-danger'];
                                ?>
                                <span class="badge <?php echo e($kategoriBadges[$item->kategori] ?? 'bg-secondary'); ?>"><?php echo e(!is_null($item->kategori_custom) ? $item->kategori_custom : ucfirst($item->kategori)); ?></span>
                            </td>
                            
                            <td><?php echo e(is_null($item->layanan_id) ? ($item->layanan_custom ?? '-') : ($item->layanan->nama_layanan ?? '-')); ?></td>
                            <td>
                                <?php
                                    $statusBadges = ['Baru' => 'bg-primary', 'Diproses' => 'bg-warning text-dark', 'Selesai' => 'bg-success'];
                                ?>
                                <span class="badge <?php echo e($statusBadges[$item->status] ?? 'bg-secondary'); ?>"><?php echo e($item->status); ?></span>
                            </td>
                            <td>
                                <?php if($item->petugas): ?>
                                    <?php echo e($item->petugas->nama); ?>

                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="fas fa-clock"></i> Menunggu Penugasan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                    <a href="<?php echo e(route('aspirasi.show', $item->id)); ?>" class="btn btn-info btn-xs custom-tooltip" data-tooltip="Lihat Detail"><i class="fas fa-eye"></i></a>
                                
                                <?php if(Auth::user()->isAdmin()): ?>
                                    <form action="<?php echo e(route('aspirasi.destroy', $item->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-xs custom-tooltip" data-tooltip="Hapus Data"><i class="fas fa-trash"></i></button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <?php echo e($aspirasi->appends(request()->query())->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>

<style>
    .btn-xs { 
        padding: 0.25rem 0.5rem; 
        font-size: 0.75rem; 
        margin: 0 2px; 
    }

    /* Custom White Tooltip (Top) */
    .custom-tooltip {
        position: relative;
    }
    .custom-tooltip::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        color: #333;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s ease-in-out;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border: 1px solid #e0e0e0;
        z-index: 10;
    }
    .custom-tooltip::after {
        content: "";
        position: absolute;
        bottom: 105%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: #fff transparent transparent transparent;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s ease-in-out;
        z-index: 10;
    }
    .custom-tooltip:hover::before,
    .custom-tooltip:hover::after {
        opacity: 1;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\simaspirasi-imigrasi\resources\views/aspirasi/index.blade.php ENDPATH**/ ?>