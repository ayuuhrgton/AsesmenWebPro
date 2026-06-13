<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Laporan - SmartParking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-3">Edit Laporan Parkir Liar</h5>
                    <form action="<?= base_url('posts/proses_update') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $laporan['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control" value="<?= $laporan['lokasi']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Jumlah Kendaraan</label>
                            <input type="number" name="jumlah_kendaraan" class="form-control" min="1" value="<?= $laporan['jumlah_kendaraan']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required><?= $laporan['deskripsi']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Foto Bukti Saat Ini</label><br>
                            <img src="<?= base_url('uploads/'.$laporan['foto_bukti']) ?>" class="img-thumbnail mb-2" style="max-height: 150px;"><br>
                            <label class="form-label small fw-semibold text-muted">Ganti Foto Baru (Kosongkan jika tidak ingin diubah):</label>
                            <input type="file" name="foto_bukti" class="form-control">
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('posts') ?>" class="btn btn-secondary w-50 fw-semibold">Batal</a>
                            <button type="submit" class="btn btn-warning w-50 fw-semibold text-white">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>