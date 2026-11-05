<?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0 !important; border-radius: 6px;">
        <div><?= $_SESSION['flash_success'] ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca !important; border-radius: 6px;">
        <div><?= $_SESSION['flash_error'] ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1" style="color: #0f172a;">Data Penghuni Aktif</h2>
        <p class="text-secondary small mb-0">Kelola riwayat penghuni yang sedang menempati kamar kost, informasi kontak, dan proses checkout.</p>
    </div>
    <div>
        <a href="<?= BASE_URL ?>/penghuni/tambah" class="btn btn-primary btn-sm px-3 shadow-none">
            Check-in Penghuni Baru
        </a>
    </div>
</div>

<div class="card card-custom p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover table-custom mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th>Nama Penghuni</th>
                    <th>NIK</th>
                    <th>No. HP / WA</th>
                    <th>Kamar &amp; Tipe</th>
                    <th>Tarif Sewa</th>
                    <th>Tgl Masuk</th>
                    <th class="text-center" style="width: 120px;">Status Sewa</th>
                    <th class="text-end" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($penghunis)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <p class="mb-2">Saat ini belum ada penghuni yang aktif menempati kamar.</p>
                            <a href="<?= BASE_URL ?>/penghuni/tambah" class="btn btn-sm btn-outline-primary">
                                Daftarkan Check-in Pertama
                            </a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($penghunis as $p): ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++ ?></td>
                            <td>
                                <strong class="text-dark"><?= htmlspecialchars($p['nama_lengkap']) ?></strong>
                            </td>
                            <td>
                                <code class="text-secondary small" style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;"><?= htmlspecialchars($p['nik']) ?></code>
                            </td>
                            <td>
                                <span class="text-secondary"><?= htmlspecialchars($p['no_hp']) ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">Kamar <?= htmlspecialchars($p['nomor_kamar'] ?? $p['nomor'] ?? '-') ?></span>
                                <span class="badge bg-light text-secondary border fw-normal ms-1" style="font-size: 0.75rem;">
                                    <?= htmlspecialchars($p['tipe_kamar'] ?? $p['tipe'] ?? '') ?>
                                </span>
                            </td>
                            <td class="text-dark">
                                Rp <?= number_format((float)($p['harga_bulanan'] ?? $p['harga'] ?? 0), 0, ',', '.') ?>
                            </td>
                            <td class="text-secondary small">
                                <?= date('d M Y', strtotime($p['tgl_masuk'])) ?>
                            </td>
                            <td class="text-center">
                                <span class="badge-tersedia" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                                    Aktif
                                </span>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="<?= BASE_URL ?>/penghuni/checkout" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin melakukan proses checkout untuk penghuni <?= htmlspecialchars(addslashes($p['nama_lengkap'])) ?> dari Kamar <?= htmlspecialchars($p['nomor_kamar'] ?? '') ?>?\n\nStatus kamar akan otomatis dikembalikan menjadi Tersedia.');">
                                    <input type="hidden" name="penghuni_id" value="<?= $p['id'] ?>">
                                    <input type="hidden" name="kamar_id" value="<?= $p['kamar_id'] ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Proses Checkout">
                                        Checkout Penghuni
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
