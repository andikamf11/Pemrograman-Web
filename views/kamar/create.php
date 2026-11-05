<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/kamar" class="text-decoration-none text-secondary">Daftar Kamar</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Kamar Baru</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca !important; border-radius: 6px;">
                <div><?= $_SESSION['flash_error'] ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <div class="card card-custom p-4">
            <div class="border-bottom pb-3 mb-4">
                <h2 class="h5 fw-semibold mb-1" style="color: #0f172a;">Form Tambah Kamar Baru</h2>
                <p class="text-muted small mb-0">Isi kelengkapan data kamar kost di bawah ini secara akurat.</p>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/kamar/simpan">
                <div class="mb-3">
                    <label for="nomor" class="form-label small fw-medium text-dark">Nomor Kamar <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nomor" name="nomor" value="<?= htmlspecialchars($old['nomor'] ?? '') ?>" placeholder="Misal: 101, A-02" required autofocus>
                    <div class="form-text small text-muted">Nomor kamar harus unik dan belum digunakan oleh kamar lain.</div>
                </div>

                <div class="mb-3">
                    <label for="tipe" class="form-label small fw-medium text-dark">Tipe Kamar <span class="text-danger">*</span></label>
                    <select class="form-select" id="tipe" name="tipe" required>
                        <option value="">-- Pilih Tipe Kamar --</option>
                        <option value="Standard" <?= (isset($old['tipe']) && $old['tipe'] === 'Standard') ? 'selected' : '' ?>>Standard</option>
                        <option value="Deluxe" <?= (isset($old['tipe']) && $old['tipe'] === 'Deluxe') ? 'selected' : '' ?>>Deluxe</option>
                        <option value="VIP" <?= (isset($old['tipe']) && $old['tipe'] === 'VIP') ? 'selected' : '' ?>>VIP</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label small fw-medium text-dark">Harga Sewa per Bulan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="harga" name="harga" value="<?= htmlspecialchars($old['harga'] ?? '') ?>" placeholder="Misal: 850000" min="1" step="1000" required>
                    <div class="form-text small text-muted">Nominal sewa wajib berupa angka positif tanpa titik atau koma.</div>
                </div>

                <div class="mb-4">
                    <label for="fasilitas" class="form-label small fw-medium text-dark">Fasilitas Kamar</label>
                    <textarea class="form-control" id="fasilitas" name="fasilitas" rows="3" placeholder="Misal: Kasur busa, lemari pakaian, AC, kamar mandi dalam, Wi-Fi"><?= htmlspecialchars($old['fasilitas'] ?? '') ?></textarea>
                    <div class="form-text small text-muted">Rincian inventaris atau fasilitas yang disediakan dalam unit kamar.</div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="<?= BASE_URL ?>/kamar" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
