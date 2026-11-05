<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1" style="color: #0f172a;">Ringkasan Operasional Kost</h2>
        <p class="text-secondary small mb-0">Pantau ketersediaan kamar, tingkat hunian, dan proyeksi omzet bulanan secara real-time.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>/penghuni/tambah" class="btn btn-outline-primary btn-sm px-3 shadow-none">
            Check-in Penghuni
        </a>
        <a href="<?= BASE_URL ?>/kamar/tambah" class="btn btn-primary btn-sm px-3 shadow-none">
            Tambah Kamar Baru
        </a>
    </div>
</div>

<!-- Kartu Ringkasan Metrik (Summary Cards) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Kamar -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-secondary small text-uppercase fw-semibold" style="letter-spacing: 0.05em; font-size: 0.75rem;">Total Kamar</span>
                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.7rem;">Kapasitas</span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="h2 fw-bold text-dark mb-0"><?= $totalKamar ?></span>
                <span class="text-muted small">Unit</span>
            </div>
            <div class="mt-2 text-secondary small" style="font-size: 0.8rem;">
                Tercatat pada master data
            </div>
        </div>
    </div>

    <!-- Card 2: Kamar Tersedia (Hijau Pastel Sesuai Panduan UI) -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3" style="border-left: 4px solid #10b981;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-secondary small text-uppercase fw-semibold" style="letter-spacing: 0.05em; font-size: 0.75rem;">Kamar Kosong</span>
                <span class="badge-tersedia">Tersedia</span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="h2 fw-bold mb-0" style="color: #065f46;"><?= $kamarTersedia ?></span>
                <span class="text-muted small">Unit</span>
            </div>
            <div class="mt-2 small" style="color: #047857; font-size: 0.8rem;">
                Siap untuk disewakan
            </div>
        </div>
    </div>

    <!-- Card 3: Kamar Terisi (Amber/Kuning Pastel Sesuai Panduan UI) -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3" style="border-left: 4px solid #f59e0b;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-secondary small text-uppercase fw-semibold" style="letter-spacing: 0.05em; font-size: 0.75rem;">Kamar Terisi</span>
                <span class="badge-terisi">Ditempati</span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="h2 fw-bold mb-0" style="color: #92400e;"><?= $kamarTerisi ?></span>
                <span class="text-muted small">Unit (<?= $totalPenghuni ?> penghuni)</span>
            </div>
            <div class="mt-2 small" style="color: #b45309; font-size: 0.8rem;">
                Okupansi: <strong><?= $okupansiPersen ?>%</strong>
            </div>
        </div>
    </div>

    <!-- Card 4: Estimasi Omzet Bulanan -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3" style="border-left: 4px solid #2563eb;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-secondary small text-uppercase fw-semibold" style="letter-spacing: 0.05em; font-size: 0.75rem;">Estimasi Omzet</span>
                <span class="badge bg-light text-primary border fw-normal" style="font-size: 0.7rem;">Per Bulan</span>
            </div>
            <div class="h3 fw-bold text-dark mb-0">
                Rp <?= number_format($estimasiOmzet, 0, ',', '.') ?>
            </div>
            <div class="mt-2 text-secondary small" style="font-size: 0.8rem;">
                Dari kamar yang berstatus terisi
            </div>
        </div>
    </div>
</div>

<!-- Baris Tingkat Okupansi & Shortcut Cepat -->
<div class="card card-custom p-3 p-md-4 mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-2">
        <div>
            <h6 class="fw-semibold mb-0" style="color: #0f172a;">Tingkat Keterisian Kamar (Occupancy Rate)</h6>
            <small class="text-secondary">Persentase kamar yang telah berpenghuni dari total unit kamar aktif</small>
        </div>
        <div class="text-md-end">
            <span class="badge bg-light text-dark border px-2 py-1 fw-medium" style="font-size: 0.85rem;">
                <?= $kamarTerisi ?> dari <?= $totalKamar ?> Terisi (<?= $okupansiPersen ?>%)
            </span>
        </div>
    </div>
    <div class="progress" style="height: 10px; background-color: #f1f5f9; border-radius: 6px;">
        <div class="progress-bar" role="progressbar" style="width: <?= $okupansiPersen ?>%; background-color: #2563eb;" aria-valuenow="<?= $okupansiPersen ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

<!-- Kolom 2 Bagian: Kamar Kosong Siap Huni & Penghuni Aktif Terkini -->
<div class="row g-4">
    <!-- Daftar Kamar Kosong Siap Sewa -->
    <div class="col-12 col-lg-6">
        <div class="card card-custom p-0 overflow-hidden h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                <div>
                    <h6 class="fw-semibold mb-0" style="color: #0f172a;">Kamar Kosong Siap Sewa</h6>
                    <small class="text-secondary">Unit yang dapat langsung ditawarkan ke calon penghuni</small>
                </div>
                <a href="<?= BASE_URL ?>/kamar?status=tersedia" class="btn btn-outline-secondary btn-sm" style="font-size: 0.75rem;">
                    Lihat Semua
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-custom mb-0">
                    <thead>
                        <tr>
                            <th>No. Kamar</th>
                            <th>Tipe</th>
                            <th>Tarif / Bln</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kamarKosongList)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">
                                    Semua unit kamar saat ini sedang terisi penuh.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kamarKosongList as $kamar): ?>
                                <tr>
                                    <td>
                                        <strong class="text-dark">Kamar <?= htmlspecialchars($kamar['nomor']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.75rem;">
                                            <?= htmlspecialchars($kamar['tipe']) ?>
                                        </span>
                                    </td>
                                    <td class="text-dark fw-medium">
                                        Rp <?= number_format((float)$kamar['harga'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= BASE_URL ?>/penghuni/tambah?kamar_id=<?= $kamar['id'] ?>" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size: 0.75rem;">
                                            Check-in
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Daftar Penghuni Aktif Terkini -->
    <div class="col-12 col-lg-6">
        <div class="card card-custom p-0 overflow-hidden h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                <div>
                    <h6 class="fw-semibold mb-0" style="color: #0f172a;">Penghuni Aktif Terkini</h6>
                    <small class="text-secondary">Daftar penghuni yang sedang menempati unit kamar</small>
                </div>
                <a href="<?= BASE_URL ?>/penghuni" class="btn btn-outline-secondary btn-sm" style="font-size: 0.75rem;">
                    Lihat Semua
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Nama Penghuni</th>
                            <th>Kamar</th>
                            <th>Tgl Masuk</th>
                            <th>No. HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($penghuniTerbaru)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">
                                    Belum ada data penghuni aktif yang tercatat.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($penghuniTerbaru as $p): ?>
                                <tr>
                                    <td>
                                        <strong class="text-dark"><?= htmlspecialchars($p['nama_lengkap']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border fw-medium" style="font-size: 0.75rem;">
                                            Kamar <?= htmlspecialchars($p['nomor_kamar'] ?? $p['nomor'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td class="text-secondary small">
                                        <?= date('d M Y', strtotime($p['tgl_masuk'])) ?>
                                    </td>
                                    <td class="text-secondary small">
                                        <?= htmlspecialchars($p['no_hp']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
