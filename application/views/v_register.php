<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Operator - SmartParking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .register-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

<div class="container register-container my-4">
    <div class="card shadow-sm" style="width: 100%; max-width: 450px; border-radius: 12px;">
        <div class="card-body p-4">
            <h4 class="text-center mb-2 fw-bold text-success">Daftar Akun</h4>
            <p class="text-muted text-center small mb-4">Registrasi Operator Baru SmartCity Kab. Bandung</p>

            <?php if(validation_errors()): ?>
                <div class="alert alert-danger alert-dismissible fade show p-2 small" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/proses_register') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Anda" value="<?= set_value('nama'); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="<?= set_value('email'); ?>" required>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Email harus berformat valid.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimum 6 karakter" required>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Panjang password minimal 6 karakter.</div>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-semibold my-2">Daftar Sekarang</button>
            </form>
            
            <div class="text-center mt-3">
                <p class="small mb-0 text-muted">Sudah punya akun? <a href="<?= base_url('auth') ?>" class="text-decoration-none text-success fw-medium">Login di sini</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>