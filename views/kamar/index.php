<?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0 !important; border-radius: 6px;">
        <div class="d-flex align-items-center">
            <span class="me-2" style="font-size: 1.1rem;">✓</span>
            <div><?= $_SESSION['flash_success'] ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca !important; border-radius: 6px;">
        <div class="d-flex align-items-center">
            <span class="me-2" style="font-size: 1.1rem;">⚠</span>
            <div><?= $_SESSION['flash_error'] ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1" style="color: #0f172a;">Daftar Kamar Kost</h2>
        <p class="text-secondary small mb-0">Kelola master data kamar, penetapan tarif sewa per bulan, fasilitas, dan ketersediaan.</p>
    </div>
    <div>
        <a href="<?= BASE_URL ?>/kamar/tambah" class="btn btn-primary btn-sm px-3 shadow-none">
            + Tambah Kamar Baru
        </a>
    </div>
</div>

<div class="card card-custom p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover table-custom mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">No</th>
                    <th>Nomor Kamar</th>
                    <th>Tipe</th>
                    <th>Harga Sewa / Bln</th>
                    <th>Fasilitas</th>
                    <th class="text-center" style="width: 140px;">Status</th>
                    <th class="text-end" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($kamars)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <p class="mb-2">Belum ada data kamar yang tersimpan.</p>
                            <a href="<?= BASE_URL ?>/kamar/tambah" class="btn btn-sm btn-outline-primary">
                                Tambah Kamar Pertama
                            </a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($kamars as $kamar): ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++ ?></td>
                            <td>
                                <strong class="text-dark">Kamar <?= htmlspecialchars($kamar['nomor']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.8rem;">
                                    <?= htmlspecialchars($kamar['tipe']) ?>
                                </span>
                            </td>
                            <td class="fw-medium text-dark">
                                Rp <?= number_format((float)$kamar['harga'], 0, ',', '.') ?>
                            </td>
                            <td class="text-secondary small" style="max-width: 320px;">
                                <?= !empty($kamar['fasilitas']) ? htmlspecialchars($kamar['fasilitas']) : '<span class="text-muted fst-italic">Tidak ada catatan fasilitas</span>' ?>
                            </td>
                            <td class="text-center">
                                <?php if ($kamar['status'] === 'terisi'): ?>
                                    <span class="badge-terisi">Terisi</span>
                                <?php else: ?>
                                    <span class="badge-tersedia">Tersedia</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="<?= BASE_URL ?>/kamar/edit/<?= $kamar['id'] ?>" class="btn btn-light btn-sm border text-secondary" title="Edit kamar">
                                        Edit
                                    </a>
                                    <?php if ($kamar['status'] === 'terisi'): ?>
                                        <button type="button" class="btn btn-light btn-sm border text-muted" disabled title="Kamar terisi tidak dapat dihapus" style="cursor: not-allowed; opacity: 0.6;">
                                            Hapus
                                        </button>
                                    <?php else: ?>
                                        <form method="POST" action="<?= BASE_URL ?>/kamar/hapus/<?= $kamar['id'] ?>" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Kamar <?= htmlspecialchars($kamar['nomor']) ?>?');">
                                            <input type="hidden" name="id" value="<?= $kamar['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus kamar">
                                                Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
