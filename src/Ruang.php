<?php

declare(strict_types=1);

abstract class Ruang implements BisaDipinjam
{
    protected const STATUS_TERSEDIA = "Tersedia";
    protected const STATUS_DIPINJAM = "Dipinjam";
    protected const KAPASITAS_MIN = 1;
    protected const KAPASITAS_MAKS = 100;

    protected string $kodeRuang;
    protected string $namaRuang;
    protected int $kapasitas;
    protected string $status;

    public function __construct(string $kodeRuang, string $namaRuang, int $kapasitas)
    {
        $this->setKodeRuang($kodeRuang);
        $this->setNamaRuang($namaRuang);
        $this->setKapasitas($kapasitas);
        $this->ubahStatus(self::STATUS_TERSEDIA);
    }

    public function getKode(): string
    {
        return $this->kodeRuang;
    }

    public function getNama(): string
    {
        return $this->namaRuang;
    }

    public function getKapasitas(): int
    {
        return $this->kapasitas;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isTersedia(): bool
    {
        return $this->status === self::STATUS_TERSEDIA;
    }

    public function pinjam(): void
    {
        if (!$this->isTersedia()) {
            throw new RuntimeException("Ruang " . $this->kodeRuang . " sedang dipinjam.");
        }

        $this->ubahStatus(self::STATUS_DIPINJAM);
    }

    public function kembalikan(): void
    {
        if ($this->isTersedia()) {
            throw new RuntimeException("Ruang " . $this->kodeRuang . " tidak sedang dipinjam.");
        }

        $this->ubahStatus(self::STATUS_TERSEDIA);
    }

    abstract public function caraAkses(): string;

    abstract public function biayaSewa(): int;

    public function syaratTambahan(): array
    {
        return [];
    }

    protected function setKodeRuang(string $kodeRuang): void
    {
        $kodeRuang = trim($kodeRuang);

        if ($kodeRuang === "") {
            throw new InvalidArgumentException("Kode ruang tidak boleh kosong.");
        }

        $this->kodeRuang = $kodeRuang;
    }

    protected function setNamaRuang(string $namaRuang): void
    {
        $namaRuang = trim($namaRuang);

        if (mb_strlen($namaRuang) < 3) {
            throw new InvalidArgumentException("Nama ruang minimal 3 karakter.");
        }

        $this->namaRuang = $namaRuang;
    }

    protected function setKapasitas(int $kapasitas): void
    {
        if ($kapasitas < self::KAPASITAS_MIN || $kapasitas > self::KAPASITAS_MAKS) {
            throw new InvalidArgumentException(
                "Kapasitas harus antara " . self::KAPASITAS_MIN
                . " sampai " . self::KAPASITAS_MAKS . " orang."
            );
        }

        $this->kapasitas = $kapasitas;
    }

    protected function ubahStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_TERSEDIA, self::STATUS_DIPINJAM], true)) {
            throw new InvalidArgumentException("Status tidak dikenal: " . $status . ".");
        }

        $this->status = $status;
    }
}
