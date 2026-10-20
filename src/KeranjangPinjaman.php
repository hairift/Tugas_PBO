<?php

declare(strict_types=1);

class KeranjangPinjaman
{
    // Lebar pemisah mengikuti format baris pada ringkasan().
    private const LEBAR_PEMISAH = 62;

    private string $namaPeminjam;
    private array $items = [];

    public function __construct(string $namaPeminjam)
    {
        $namaPeminjam = trim($namaPeminjam);

        if ($namaPeminjam === "") {
            throw new InvalidArgumentException("Nama peminjam tidak boleh kosong.");
        }

        $this->namaPeminjam = $namaPeminjam;
    }

    public function getNamaPeminjam(): string
    {
        return $this->namaPeminjam;
    }

    public function tambah(BisaDipinjam $item): void
    {
        foreach ($this->items as $tersimpan) {
            if ($tersimpan->getKode() === $item->getKode()) {
                throw new InvalidArgumentException(
                    "Item " . $item->getKode() . " sudah ada di keranjang."
                );
            }
        }

        $this->items[] = $item;
    }

    public function jumlahItem(): int
    {
        return count($this->items);
    }

    public function totalBiaya(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->biayaSewa();
        }

        return $total;
    }

    public function semuaTersedia(): bool
    {
        foreach ($this->items as $item) {
            if (!$item->isTersedia()) {
                return false;
            }
        }

        return true;
    }

    public function pinjamSemua(): void
    {
        if (!$this->semuaTersedia()) {
            throw new RuntimeException("Ada item yang tidak tersedia, peminjaman dibatalkan.");
        }

        foreach ($this->items as $item) {
            $item->pinjam();
        }
    }

    public function kembalikanSemua(): void
    {
        foreach ($this->items as $item) {
            if (!$item->isTersedia()) {
                $item->kembalikan();
            }
        }
    }

    public function ringkasan(): string
    {
        $baris = [
            "Keranjang pinjaman " . $this->namaPeminjam . " (" . $this->jumlahItem() . " item)",
            str_repeat("-", self::LEBAR_PEMISAH),
        ];

        foreach ($this->items as $item) {
            $baris[] = sprintf(
                "%-10s %-30s Rp%-9s %s",
                $item->getKode(),
                $item->getNama(),
                number_format($item->biayaSewa(), 0, ",", "."),
                $item->isTersedia() ? "Tersedia" : "Dipinjam"
            );
        }

        $baris[] = str_repeat("-", self::LEBAR_PEMISAH);
        $baris[] = "Total tarif per jam: Rp" . number_format($this->totalBiaya(), 0, ",", ".");

        return implode(PHP_EOL, $baris);
    }
}
