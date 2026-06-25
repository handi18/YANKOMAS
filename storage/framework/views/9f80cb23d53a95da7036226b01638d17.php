

<?php $__env->startSection('title', 'Data Aspirasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list"></i> Data Aspirasi</h5>
        <a href="<?php echo e(route('aspirasi.create')); ?>" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Aspirasi
        </a>
    </div>
    
    <div class="card-body">
        <!-- Filter Section -->
        <form method="GET" class="mb-4">
            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="filter" class="form-select form-select-sm">
                        <option value="">Semua Periode</option>
                        <option value="today" <?php echo e(request('filter') === 'today' ? 'selected' : ''); ?>>Hari Ini</option>
                        <option value="week" <?php echo e(request('filter') === 'week' ? 'selected' : ''); ?>>Minggu Ini</option>
                        <option value="month" <?php echo e(request('filter') === 'month' ? 'selected' : ''); ?>>Bulan Ini</option>
                        <option value="year" <?php echo e(request('filter') === 'year' ? 'selected' : ''); ?>>Tahun Ini</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control form-control-sm" placeholder="Dari Tanggal" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control form-control-sm" placeholder="Sampai Tanggal" value="<?php echo e(request('date_to')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="jenis" class="form-select form-select-sm">
                        <option value="">Semua Jenis</option>
                        <option value="saran" <?php echo e(request('jenis') === 'saran' ? 'selected' : ''); ?>>Saran</option>
                        <option value="masukan" <?php echo e(request('jenis') === 'masukan' ? 'selected' : ''); ?>>Masukan</option>
                        <option value="pengaduan" <?php echo e(request('jenis') === 'pengaduan' ? 'selected' : ''); ?>>Pengaduan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        <option value="ringan" <?php echo e(request('kategori') === 'ringan' ? 'selected' : ''); ?>>Ringan</option>
                        <option value="sedang" <?php echo e(request('kategori') === 'sedang' ? 'selected' : ''); ?>>Sedang</option>
                        <option value="berat" <?php echo e(request('kategori') === 'berat' ? 'selected' : ''); ?>>Berat</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Baru" <?php echo e(request('status') === 'Baru' ? 'selected' : ''); ?>>Baru</option>
                        <option value="Diproses" <?php echo e(request('status') === 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                        <option value="Selesai" <?php echo e(request('status') === 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="layanan_id" class="form-select form-select-sm">
                        <option value="">Semua Layanan</option>
                        <?php $__currentLoopData = $layanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e(request('layanan_id') == $item->id ? 'selected' : ''); ?>>
                                <?php echo e($item->nama_layanan); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nomor tiket..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('aspirasi.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Export Buttons -->
        <div class="mb-3">
            <a href="<?php echo e(route('aspirasi.export-excel', request()->query())); ?>" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="<?php echo e(route('aspirasi.export-pdf', request()->query())); ?>" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Tiket</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Layanan</th>
                        <th>Media</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $aspirasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($item->nomor_tiket); ?></strong></td>
                            <td><?php echo e($item->tanggal_kejadian->format('d/m/Y')); ?></td>
                            <td><?php echo e($item->jam_kejadian->format('H:i')); ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo e(ucfirst($item->jenis)); ?></span>
                            </td>
                            <td>
                                <?php if($item->kategori === 'ringan'): ?>
                                    <span class="badge bg-success"><?php echo e(ucfirst($item->kategori)); ?></span>
                                <?php elseif($item->kategori === 'sedang'): ?>
                                    <span class="badge bg-warning"><?php echo e(ucfirst($item->kategori)); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><?php echo e(ucfirst($item->kategori)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($item->layanan->nama_layanan); ?></td>
                            <td><?php echo e($item->media); ?></td>
                            <td>
                                <?php if($item->status === 'Baru'): ?>
                                    <span class="badge bg-primary"><?php echo e($item->status); ?></span>
                                <?php elseif($item->status === 'Diproses'): ?>
                                    <span class="badge bg-warning"><?php echo e($item->status); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success"><?php echo e($item->status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($item->petugas->nama); ?></td>
                            <td>
                                <a href="<?php echo e(route('aspirasi.show', $item->id)); ?>" class="btn btn-info btn-xs" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if(Auth::user()->isAdmin() || Auth::user()->id === $item->petugas_id): ?>
                                    <a href="<?php echo e(route('aspirasi.edit', $item->id)); ?>" class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if(Auth::user()->isAdmin()): ?>
                                    <form action="<?php echo e(route('aspirasi.destroy', $item->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($aspirasi->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>

<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        margin: 0 2px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\Magang\projek magang\simaspirasi-imigrasi\resources\views/aspirasi/index.blade.php ENDPATH**/ ?>