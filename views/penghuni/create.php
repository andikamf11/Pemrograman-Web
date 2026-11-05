<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/penghuni" class="text-decoration-none text-secondary">Data Penghuni</a></li>
        <li class="breadcrumb-item active" aria-current="page">Check-in Penghuni Baru</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca !important; border-radius: 6px;">
                <div><?= $_SESSION['flash_error'] ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <div class="card card-custom p-4">
            <div class="border-bottom pb-3 mb-4">
                <h2 class="h5 fw-semibold mb-1" style="color: #0f172a;">Form Check-in Penghuni Baru</h2>
                <p class="text-muted small mb-0">Lengkapi formulir di bawah ini untuk mendaftarkan penghuni dan mengalokasikan kamar kost.</p>
            </div>

            <?php if (empty($availableRooms)): ?>
                <div class="alert alert-warning border-0 mb-4" style="background-color: #fffbeb; color: #92400e; border: 1px solid #fde68a !important; border-radius: 6px;">
                    <div>
                        <strong>Tidak Ada Kamar Tersedia</strong><br>
                        Saat ini seluruh kamar kost telah berstatus <em>Terisi</em>. Anda dapat menambahkan master kamar baru terlebih dahulu atau melakukan checkout pada kamar yang sudah ada.
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="<?= BASE_URL ?>/penghuni" class="btn btn-outline-secondary">Kembali</a>
                    <a href="<?= BASE_URL ?>/kamar/tambah" class="btn btn-primary">Tambah Kamar Baru</a>
                </div>
            <?php else: ?>
                <form method="POST" action="<?= BASE_URL ?>/penghuni/simpan">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label small fw-medium text-dark">Nama Lengkap Penghuni <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($old['nama_lengkap'] ?? '') ?>" placeholder="Misal: Ahmad Fauzi" required autofocus>
                        <div class="form-text small text-muted">Nama lengkap sesuai dengan identitas KTP.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label small fw-medium text-dark">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($old['nik'] ?? '') ?>" placeholder="16 digit nomor NIK" minlength="16" maxlength="20" required>
                            <div class="form-text small text-muted">Minimal 16 digit angka sesuai KTP.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label small fw-medium text-dark">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($old['no_hp'] ?? '') ?>" placeholder="Misal: 081234567890" pattern="[0-9]+" required>
                            <div class="form-text small text-muted">Hanya masukkan angka tanpa tanda spasi atau strip.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kamar_id" class="form-label small fw-medium text-dark">Pilih Kamar Kost <span class="text-danger">*</span></label>
                            <select class="form-select" id="kamar_id" name="kamar_id" required>
                                <option value="">-- Pilih Kamar Tersedia --</option>
                                <?php foreach ($availableRooms as $room): ?>
                                    <option value="<?= $room['id'] ?>" <?= ((isset($selectedKamarId) && (int)$selectedKamarId === (int)$room['id']) || (isset($old['kamar_id']) && (int)$old['kamar_id'] === (int)$room['id'])) ? 'selected' : '' ?>>
                                        Kamar <?= htmlspecialchars($room['nomor']) ?> - Tipe <?= htmlspecialchars($room['tipe']) ?> (Rp <?= number_format((float)$room['harga'], 0, ',', '.') ?>/bln)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text small text-muted">Hanya menampilkan kamar yang berstatus kosong/tersedia.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tgl_masuk" class="form-label small fw-medium text-dark">Tanggal Mulai Masuk Sewa <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" value="<?= htmlspecialchars($old['tgl_masuk'] ?? date('Y-m-d')) ?>" required>
                            <div class="form-text small text-muted">Tanggal awal penghuni mulai menempati kamar.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                        <a href="<?= BASE_URL ?>/penghuni" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Proses Check-in</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
