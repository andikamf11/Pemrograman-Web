<?php

namespace App\Model;

/**
 * Model Entity Penghuni
 * Menangani data entitas penghuni dan relasi kamar
 */
class Penghuni
{
    private ?int $id;
    private int $kamarId;
    private string $namaLengkap;
    private string $nik;
    private string $noHp;
    private string $tglMasuk;
    private ?string $tglKeluar;
    private string $statusSewa;
    private ?string $createdAt;

    // Properti relasi dari tabel kamar (JOIN)
    private ?string $nomorKamar;
    private ?string $tipeKamar;
    private ?float $hargaBulanan;

    public function __construct(
        ?int $id = null,
        int $kamarId = 0,
        string $namaLengkap = '',
        string $nik = '',
        string $noHp = '',
        string $tglMasuk = '',
        ?string $tglKeluar = null,
        string $statusSewa = 'aktif',
        ?string $createdAt = null,
        ?string $nomorKamar = null,
        ?string $tipeKamar = null,
        ?float $hargaBulanan = null
    ) {
        $this->id = $id;
        $this->kamarId = $kamarId;
        $this->namaLengkap = $namaLengkap;
        $this->nik = $nik;
        $this->noHp = $noHp;
        $this->tglMasuk = $tglMasuk;
        $this->tglKeluar = $tglKeluar;
        $this->statusSewa = $statusSewa;
        $this->createdAt = $createdAt;
        $this->nomorKamar = $nomorKamar;
        $this->tipeKamar = $tipeKamar;
        $this->hargaBulanan = $hargaBulanan;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKamarId(): int
    {
        return $this->kamarId;
    }

    public function getNamaLengkap(): string
    {
        return $this->namaLengkap;
    }

    public function getNik(): string
    {
        return $this->nik;
    }

    public function getNoHp(): string
    {
        return $this->noHp;
    }

    public function getTglMasuk(): string
    {
        return $this->tglMasuk;
    }

    public function getTglKeluar(): ?string
    {
        return $this->tglKeluar;
    }

    public function getStatusSewa(): string
    {
        return $this->statusSewa;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getNomorKamar(): ?string
    {
        return $this->nomorKamar;
    }

    public function getTipeKamar(): ?string
    {
        return $this->tipeKamar;
    }

    public function getHargaBulanan(): ?float
    {
        return $this->hargaBulanan;
    }

    public function isAktif(): bool
    {
        return $this->statusSewa === 'aktif';
    }

    public function isSelesai(): bool
    {
        return $this->statusSewa === 'selesai';
    }

    /**
     * Factory method membuat object Penghuni dari associative array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (int)$data['id'] : null,
            isset($data['kamar_id']) ? (int)$data['kamar_id'] : 0,
            $data['nama_lengkap'] ?? $data['nama'] ?? '',
            $data['nik'] ?? '',
            $data['no_hp'] ?? '',
            $data['tgl_masuk'] ?? '',
            $data['tgl_keluar'] ?? null,
            $data['status_sewa'] ?? 'aktif',
            $data['created_at'] ?? null,
            $data['nomor_kamar'] ?? $data['nomor'] ?? null,
            $data['tipe_kamar'] ?? $data['tipe'] ?? null,
            isset($data['harga_bulanan']) ? (float)$data['harga_bulanan'] : (isset($data['harga']) ? (float)$data['harga'] : null)
        );
    }

    /**
     * Konversi object Penghuni ke array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'kamar_id' => $this->kamarId,
            'nama_lengkap' => $this->namaLengkap,
            'nik' => $this->nik,
            'no_hp' => $this->noHp,
            'tgl_masuk' => $this->tglMasuk,
            'tgl_keluar' => $this->tglKeluar,
            'status_sewa' => $this->statusSewa,
            'created_at' => $this->createdAt,
            'nomor_kamar' => $this->nomorKamar,
            'tipe_kamar' => $this->tipeKamar,
            'harga_bulanan' => $this->hargaBulanan,
        ];
    }
}

