

<?php $__env->startSection('title', 'Kelola Petugas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users"></i> Kelola Petugas</h5>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Petugas
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->nama); ?></td>
                            <td><?php echo e($user->nip); ?></td>
                            <td><?php echo e($user->username); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php if($user->role === 'superadmin' || $user->isSuperAdmin()): ?>
                                    <span class="badge bg-dark">Super Admin</span>
                                <?php elseif($user->role === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-info">Petugas</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-warning btn-xs custom-tooltip" data-tooltip="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($user->id !== Auth::id()): ?>
                                    <?php if(!$user->isSuperAdmin()): ?>
                                    <form action="<?php echo e(route('admin.users.reset-password', $user->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-info btn-xs custom-tooltip" data-tooltip="Reset Password" onclick="return confirm('Reset password ke default?')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($user->id !== Auth::id()): ?>
                                    <?php if(!$user->isSuperAdmin()): ?>
                                    <form action="<?php echo e(route('admin.users.delete', $user->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-xs custom-tooltip" data-tooltip="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <?php echo e($users->links('pagination::bootstrap-5')); ?>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\simaspirasi-imigrasi\resources\views/admin/users/index.blade.php ENDPATH**/ ?>