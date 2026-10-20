<?php

declare(strict_types=1);

class Peralatan implements BisaDipinjam
{
    private const PANJANG_NAMA_MIN = 3;

    private string $kode;
    private string $nama;
    private int $biayaPerJam;
    private bool $tersedia;

    public function __construct(string $kode, string $nama, int $biayaPerJam)
    {
        $kode = trim($kode);
        $nama = trim($nama);

        if ($kode === "") {
            throw new InvalidArgumentException("Kode peralatan tidak boleh kosong.");
        }

        if (mb_strlen($nama) < self::PANJANG_NAMA_MIN) {
            throw new InvalidArgumentException(
                "Nama peralatan minimal " . self::PANJANG_NAMA_MIN . " karakter."
            );
        }

        if ($biayaPerJam <= 0) {
            throw new InvalidArgumentException("Biaya sewa peralatan harus lebih dari nol.");
        }

        $this->kode = $kode;
        $this->nama = $nama;
        $this->biayaPerJam = $biayaPerJam;
        $this->tersedia = true;
    }

    public function getKode(): string
    {
        return $this->kode;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function biayaSewa(): int
    {
        return $this->biayaPerJam;
    }

    public function isTersedia(): bool
    {
        return $this->tersedia;
    }

    public function pinjam(): void
    {
        if (!$this->tersedia) {
            throw new RuntimeException("Peralatan " . $this->kode . " sedang dipinjam.");
        }

        $this->tersedia = false;
    }

    public function kembalikan(): void
    {
        if ($this->tersedia) {
            throw new RuntimeException("Peralatan " . $this->kode . " tidak sedang dipinjam.");
        }

        $this->tersedia = true;
    }
}
