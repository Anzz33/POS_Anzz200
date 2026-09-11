<?php $__env->startSection('title', 'Daftar Produk'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* 1. Hilangkan background pekat pembungkus utama */
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

    /* 2. Card Utama (Glassmorphism Dark) */
    .produk-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    /* 3. Sub-box Isian Dalam */
    .produk-card-inner {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    /* 4. Tabel Transparan */
    .table-produk {
        color: #ffffff !important;
        background-color: transparent !important;
        vertical-align: middle;
    }

    .table-produk th {
        background-color: rgba(15, 17, 23, 0.8) !important;
        color: #a0aec0 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .table-produk td {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
    }

    .table-produk tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.04) !important;
    }

    /* Input Cari */
    .input-dark {
        background-color: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    .input-dark::placeholder {
        color: #a0aec0 !important;
    }

    .input-dark:focus {
        background-color: rgba(15, 17, 23, 0.8) !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
        color: #ffffff !important;
    }

    /* Thumbnail Foto Produk */
    .img-thumb-produk {
        width: 38px;
        height: 38px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .img-placeholder-produk {
        width: 38px;
        height: 38px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px dashed rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
    }

    /* Badges Stok */
    .badge-stok-high {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border: 1px solid rgba(52, 211, 153, 0.4);
    }

    .badge-stok-medium {
        background-color: rgba(245, 158, 11, 0.2) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(251, 191, 36, 0.4);
    }

    .badge-stok-low {
        background-color: rgba(239, 68, 68, 0.2) !important;
        color: #f87171 !important;
        border: 1px solid rgba(248, 113, 113, 0.4);
    }
</style>

<div class="card produk-card-main border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <!-- Header Atas -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h2 class="fw-bold text-white mb-1">Produk</h2>
                <p class="mb-0 small" style="color: #a0aec0 !important;">Kelola seluruh data produk toko Anda.</p>
            </div>
            <div>
                <a href="<?php echo e(route('produk.create')); ?>" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                    + Tambah Produk
                </a>
            </div>
        </div>

        <!-- Filter Cari -->
        <div class="produk-card-inner p-3 mb-4">
            <form action="<?php echo e(route('produk.index')); ?>" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5 col-12">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control input-dark rounded-3" placeholder="Cari nama produk...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4 rounded-3">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Inner Box Table -->
        <div class="produk-card-inner p-3">
            <div class="d-flex align-items-center gap-2 mb-3 px-1">
                <span class="badge bg-warning p-1 rounded-1"></span>
                <h6 class="fw-bold text-white m-0">Daftar Produk</h6>
            </div>

            <div class="table-responsive rounded-3 border border-secondary border-opacity-25">
                <table class="table table-produk align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 50px;">NO</th>
                            <th class="py-3 px-3">USER</th>
                            <th class="py-3 px-3 text-center" style="width: 60px;">FOTO</th>
                            <th class="py-3 px-3">NAMA PRODUK</th>
                            <th class="py-3 px-3">HARGA BELI</th>
                            <th class="py-3 px-3">HARGA JUAL</th>
                            <th class="py-3 px-3 text-center">STOK</th>
                            <th class="py-3 px-3 text-center" style="width: 170px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center fw-semibold" style="color: #a0aec0 !important;">
                                    <?php echo e(method_exists($produk, 'firstItem') ? $produk->firstItem() + $index : $index + 1); ?>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle text-white-50"></i>
                                        <span><?php echo e($item->user->name ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if(!empty($item->foto)): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->foto)); ?>" alt="Foto" class="img-thumb-produk">
                                    <?php else: ?>
                                        <div class="img-placeholder-produk mx-auto">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-semibold text-white">
                                    <?php echo e($item->nama_produk ?? $item->nama); ?>

                                </td>
                                <td class="text-white-50">
                                    Rp <?php echo e(number_format($item->harga_beli ?? 0, 0, ',', '.')); ?>

                                </td>
                                <td class="fw-bold text-warning">
                                    Rp <?php echo e(number_format($item->harga_jual ?? $item->harga ?? 0, 0, ',', '.')); ?>

                                </td>
                                <td class="text-center">
                                    <?php
                                        $stok = $item->stok ?? 0;
                                        $badgeClass = $stok > 10 ? 'badge-stok-high' : ($stok > 0 ? 'badge-stok-medium' : 'badge-stok-low');
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?> px-3 py-2 rounded-pill fw-semibold fs-8"><?php echo e($stok); ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo e(route('produk.show', $item->id)); ?>" class="btn btn-sm btn-info text-white rounded-2 px-2 py-1" style="font-size: 0.75rem;">
                                            Detail
                                        </a>
                                        <a href="<?php echo e(route('produk.edit', $item->id)); ?>" class="btn btn-sm btn-warning text-dark rounded-2 px-2 py-1 fw-semibold" style="font-size: 0.75rem;">
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('produk.destroy', $item->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                                <td colspan="8" class="text-center py-5" style="color: #a0aec0 !important;">
                                    Belum ada data produk.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if(method_exists($produk, 'links')): ?>
                <div class="d-flex justify-content-end mt-3">
                    <!-- <?php echo e($produk->links()); ?> -->
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.produk-card-main');
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\POS_ANJA99-main\resources\views/produk/index.blade.php ENDPATH**/ ?>