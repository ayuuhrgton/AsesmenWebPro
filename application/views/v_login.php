<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartParking Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <div class="card-body p-4">
            <h4 class="text-center mb-3 fw-bold text-primary">SmartParking Report</h4>
            <p class="text-muted text-center small mb-4">Silahkan login sebagai Operator Kabupaten Bandung</p>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show p-2 small" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/proses_login') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-semibold my-2">Masuk Halaman</button>
            </form>
            
            <div class="text-center mt-3">
                <p class="small mb-0 text-muted">Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="text-decoration-none">Daftar sekarang</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>