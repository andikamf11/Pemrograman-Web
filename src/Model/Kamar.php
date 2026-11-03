<?php

namespace App\Model;

/**
 * Model Entity Kamar
 */
class Kamar
{
    private ?int $id;
    private string $nomor;
    private string $tipe;
    private float $harga;
    private ?string $fasilitas;
    private string $status;
    private ?string $createdAt;

    public function __construct(
        ?int $id = null,
        string $nomor = '',
        string $tipe = '',
        float $harga = 0.0,
        ?string $fasilitas = '',
        string $status = 'tersedia',
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->nomor = $nomor;
        $this->tipe = $tipe;
        $this->harga = $harga;
        $this->fasilitas = $fasilitas;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomor(): string
    {
        return $this->nomor;
    }

    public function getTipe(): string
    {
        return $this->tipe;
    }

    public function getHarga(): float
    {
        return $this->harga;
    }

    public function getFasilitas(): ?string
    {
        return $this->fasilitas;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function isTerisi(): bool
    {
        return $this->status === 'terisi';
    }

    public function isTersedia(): bool
    {
        return $this->status === 'tersedia';
    }

    /**
     * Factory method membuat object Kamar dari associative array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (int)$data['id'] : null,
            $data['nomor'] ?? '',
            $data['tipe'] ?? '',
            isset($data['harga']) ? (float)$data['harga'] : 0.0,
            $data['fasilitas'] ?? '',
            $data['status'] ?? 'tersedia',
            $data['created_at'] ?? null
        );
    }

    /**
     * Konversi object Kamar ke array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nomor' => $this->nomor,
            'tipe' => $this->tipe,
            'harga' => $this->harga,
            'fasilitas' => $this->fasilitas,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}
