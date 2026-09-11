<?php $__env->startSection('title', 'Tambah User'); ?>

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
    .create-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    /* Sub Card Form */
    .create-card-inner {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    /* Input & Select Dark */
    .input-dark {
        background-color: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    .input-dark option {
        background-color: #161b22 !important;
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

    /* Perbaikan Autofill Browser agar tetap gelap */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #11141a inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>

<div class="card create-card-main border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <!-- Header Atas -->
        <div class="mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <h2 class="fw-bold text-white mb-1">Tambah User</h2>
            <p class="mb-0 small" style="color: #a0aec0 !important;">Isi formulir berikut untuk menambahkan pengguna baru ke sistem POS.</p>
        </div>

        <form action="<?php echo e(route('users.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Inner Form Card -->
            <div class="create-card-inner p-4 mb-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge bg-warning p-1 rounded-1"></span>
                    <h6 class="fw-bold text-white m-0">Data User Baru</h6>
                </div>

                <div class="row g-3">
                    <!-- Nama -->
                    <div class="col-md-6">
                        <label class="form-label small text-white-50 mb-1">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control input-dark rounded-3" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label small text-white-50 mb-1">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control input-dark rounded-3" placeholder="Masukkan email" required>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label small text-white-50 mb-1">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control input-dark rounded-3" placeholder="Masukkan password" required>
                    </div>

                    <!-- Role -->
                    <div class="col-md-6">
                        <label class="form-label small text-white-50 mb-1">Role <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select input-dark rounded-3" required>
                            <option value="" selected disabled>-- Pilih Role --</option>
                            <?php if(isset($roles) && count($roles) > 0): ?>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>"><?php echo e($role->nama_role ?? $role->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <option value="1">Admin</option>
                                <option value="2">Kasir</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary px-4 rounded-3 text-white border-secondary">
                    &larr; Kembali
                </a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 rounded-3">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.create-card-main');
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\POS_Anzz100-main\resources\views/users/create.blade.php ENDPATH**/ ?>