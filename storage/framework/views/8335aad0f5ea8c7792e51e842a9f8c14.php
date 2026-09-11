<?php $__env->startSection('title', 'Jenis Barang'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Hilangkan background pekat pembungkus utama */
    html, body, #app, main, 
    .main-content, .content-wrapper, .content, 
    .container, .container-fluid, .page-content,
    div[class*="content"], div[class*="wrapper"] {
        background-color: transparent !important;
    }

    body {
        background: linear-gradient(rgba(10, 10, 12, 0.75), rgba(10, 10, 12, 0.85)), 
                    url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* Card Utama Glassmorphism Dark */
    .jenis-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    /* Sub Card Inner */
    .jenis-card-inner {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    /* Tabel Transparan */
    .table-jenis {
        color: #ffffff !important;
        background-color: transparent !important;
        vertical-align: middle;
    }

    .table-jenis th {
        background-color: rgba(15, 17, 23, 0.8) !important;
        color: #a0aec0 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .table-jenis td {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
    }

    .table-jenis tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.04) !important;
    }
</style>

<div class="card jenis-card-main border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <!-- Header Atas -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h2 class="fw-bold text-white mb-1">Jenis Barang</h2>
                <p class="mb-0 small" style="color: #a0aec0 !important;">Kelola daftar kategori dan jenis barang di sistem POS.</p>
            </div>
            <div>
                <a href="<?php echo e(route('jenis.create')); ?>" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                    + Tambah Jenis
                </a>
            </div>
        </div>

        <!-- Inner Box Table -->
        <div class="jenis-card-inner p-3">
            <div class="d-flex align-items-center gap-2 mb-3 px-1">
                <span class="badge bg-warning p-1 rounded-1"></span>
                <h6 class="fw-bold text-white m-0">Daftar Jenis Barang</h6>
            </div>

            <div class="table-responsive rounded-3 border border-secondary border-opacity-25">
                <table class="table table-jenis align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 60px;">NO</th>
                            <th class="py-3 px-3">NAMA JENIS</th>
                            <th class="py-3 px-3">DESKRIPSI</th>
                            <th class="py-3 px-3">INPUT OLEH</th>
                            <th class="py-3 px-3 text-center" style="width: 150px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center fw-semibold" style="color: #a0aec0 !important;">
                                    <?php echo e(method_exists($jenis, 'firstItem') ? $jenis->firstItem() + $index : $index + 1); ?>

                                </td>
                                <td class="fw-semibold text-white">
                                    <?php echo e($item->nama_jenis ?? $item->nama); ?>

                                </td>
                                <td class="text-white-50">
                                    <?php echo e($item->deskripsi ?? '-'); ?>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle text-white-50"></i>
                                        <span><?php echo e($item->user->name ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo e(route('jenis.edit', $item->id)); ?>" class="btn btn-sm btn-warning text-dark rounded-2 px-2 py-1 fw-semibold" style="font-size: 0.75rem;">
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('jenis.destroy', $item->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jenis barang ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger rounded-2 px-2 py-1" style="font-size: 0.75rem;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5" style="color: #a0aec0 !important;">
                                    Belum ada data jenis barang.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if(method_exists($jenis, 'links')): ?>
                <div class="d-flex justify-content-end mt-3">
                    <?php echo e($jenis->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.jenis-card-main');
        if (card) {
            let parent = card.parentElement;
            while (parent && parent !== document.body) {
                parent.style.setProperty('background-color', 'transparent', 'important');
                parent.style.setProperty('background-image', 'none', 'important');
                parent.classList.remove('bg-white', 'bg-light', 'bg-body', 'bg-dark');
                parent = parent.parentElement;
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\POS_Anzz100-main\resources\views/jenis/index.blade.php ENDPATH**/ ?>