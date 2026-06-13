<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SmartParking Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">SmartParking Dashboard</a>
        <div class="d-flex align-items-center">
            <span class="navbar-text text-white me-3 fw-medium">Halo, <?= $this->session->userdata('nama'); ?>!</span>
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light btn-sm fw-semibold">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-3">Buat Laporan Baru</h5>
                    <form action="<?= base_url('dashboard/simpan') ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Misal: Pasar Baleendah, RSUD" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Jumlah Kendaraan Terparkir</label>
                            <input type="number" name="jumlah_kendaraan" class="form-control" min="1" placeholder="0" required>
                            <div class="form-text small" style="font-size: 0.75rem;">Status otomatis dihitung sistem (1-5 Ringan, 6-15 Sedang, >15 Berat)</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Deskripsi Situasi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tulis rincian pelanggaran..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Foto Bukti Pendukung</label>
                            <input type="file" name="foto_bukti" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-semibold">Kirim Aduan Resmi</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="card bg-white border-0 shadow-sm rounded-3 p-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted small mb-1 uppercase fw-semibold text-uppercase tracking-wider">Total Kontribusi Anda</h6>
                    <h3 class="fw-bold mb-0 text-primary"><?= $total_laporan; ?> Laporan Terkirim</h3>
                </div>
                <div class="badge bg-primary-subtle text-primary p-3 rounded-pill fs-4">📋</div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-3">Arsip Laporan Parkir Liar Anda</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-uppercase">
                                <tr>
                                    <th>Lokasi</th>
                                    <th>Waktu</th>
                                    <th class="text-center">Kendaraan</th>
                                    <th>Tingkat Pelanggaran</th>
                                    <th class="text-center">Bukti</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <?php if(!empty($laporan_user)): ?>
                                    <?php foreach($laporan_user as $l): ?>
                                    <tr>
                                        <td class="fw-semibold text-dark"><?= $l['lokasi']; ?></td>
                                        <td class="text-muted"><?= date('d M Y, H:i', strtotime($l['waktu_laporan'])); ?></td>
                                        <td class="text-center fw-medium"><?= $l['jumlah_kendaraan']; ?> unit</td>
                                        <td>
                                            <?php 
                                                $badge_color = 'bg-secondary';
                                                if ($l['status_pelanggaran'] == 'Ringan') $badge_color = 'bg-info text-dark';
                                                elseif ($l['status_pelanggaran'] == 'Sedang') $badge_color = 'bg-warning text-dark';
                                                elseif ($l['status_pelanggaran'] == 'Berat') $badge_color = 'bg-danger';
                                            ?>
                                            <span class="badge <?= $badge_color; ?> px-2 py-1"><?= $l['status_pelanggaran']; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if($l['foto_bukti']): ?>
                                                <a href="<?= base_url('uploads/'.$l['foto_bukti']) ?>" target="_blank" class="btn btn-outline-primary btn-sm px-2 py-1" style="font-size: 0.75rem;">Lihat Berkas</a>
                                            <?php else: ?>
                                                <span class="text-muted small">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('posts/edit/'.$l['id']) ?>" class="btn btn-outline-warning btn-sm px-2 py-1 me-1" style="font-size: 0.75rem;">Edit</a>

                                            <a href="<?= base_url('posts/hapus/'.$l['id']) ?>" class="btn btn-outline-danger btn-sm px-2 py-1" style="font-size: 0.75rem;" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat laporan yang terekam di sistem.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>