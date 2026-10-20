<?php

declare(strict_types=1);

require_once __DIR__ . "/src/BisaDipinjam.php";
require_once __DIR__ . "/src/Ruang.php";
require_once __DIR__ . "/src/RuangKuliah.php";
require_once __DIR__ . "/src/Laboratorium.php";
require_once __DIR__ . "/src/RuangDiskusi.php";
require_once __DIR__ . "/src/Peralatan.php";
require_once __DIR__ . "/src/KeranjangPinjaman.php";

function judul(string $teks): void
{
    echo PHP_EOL . "=== " . $teks . " ===" . PHP_EOL . PHP_EOL;
}

function rupiah(int $nilai): string
{
    return "Rp" . number_format($nilai, 0, ",", ".");
}

// Kedua fungsi ini hanya mengenal tipe, bukan class konkret pemanggilnya.
function cetakTarif(BisaDipinjam $item): void
{
    echo sprintf("%-24s %s per jam", $item->getNama(), rupiah($item->biayaSewa())) . PHP_EOL;
}

function cetakCaraAkses(Ruang $ruang): void
{
    echo sprintf("%-24s %s", $ruang->getNama(), $ruang->caraAkses()) . PHP_EOL;
}

$ruangKuliah  = new RuangKuliah("A.201", "Ruang Kuliah A", 40);
$laboratorium = new Laboratorium("LAB-1", "Laboratorium Jaringan", 30);
$ruangDiskusi = new RuangDiskusi("D.101", "Ruang Diskusi 1", 8);
$proyektor    = new Peralatan("PRJ-01", "Proyektor Epson", 15000);
$laptop       = new Peralatan("LPT-01", "Laptop Lenovo", 25000);

judul("1. ATURAN TIAP JENIS RUANG");

foreach ([$ruangKuliah, $laboratorium, $ruangDiskusi] as $ruang) {
    echo $ruang->getNama() . " (" . $ruang->getKode() . ")" . PHP_EOL;
    echo "  Kapasitas  : " . $ruang->getKapasitas() . " orang" . PHP_EOL;
    echo "  Cara akses : " . $ruang->caraAkses() . PHP_EOL;
    echo "  Tarif      : " . rupiah($ruang->biayaSewa()) . " per jam" . PHP_EOL;

    $syarat = $ruang->syaratTambahan();
    if ($syarat !== []) {
        echo "  Syarat     : " . implode(PHP_EOL . "               ", $syarat) . PHP_EOL;
    }

    echo PHP_EOL;
}

judul("2. POLYMORPHISM PADA INTERFACE BisaDipinjam");
echo "cetakTarif(BisaDipinjam \$item) dipanggil untuk lima objek berbeda." . PHP_EOL . PHP_EOL;

foreach ([$ruangKuliah, $laboratorium, $ruangDiskusi, $proyektor, $laptop] as $item) {
    cetakTarif($item);
}

judul("3. POLYMORPHISM PADA ABSTRACT CLASS Ruang");
echo "cetakCaraAkses(Ruang \$ruang) hanya mengenal tipe Ruang." . PHP_EOL . PHP_EOL;

foreach ([$ruangKuliah, $laboratorium, $ruangDiskusi] as $ruang) {
    cetakCaraAkses($ruang);
}

judul("4. COMPOSITION: KERANJANG PINJAMAN");

$keranjang = new KeranjangPinjaman("Rani");
$keranjang->tambah($ruangKuliah);
$keranjang->tambah($proyektor);
$keranjang->tambah($laptop);
echo $keranjang->ringkasan() . PHP_EOL;

judul("5. UJI ATURAN DAN PENOLAKAN");

try {
    $keranjang->tambah($ruangKuliah);
} catch (InvalidArgumentException $e) {
    echo "tambah() item ganda ditolak: " . $e->getMessage() . PHP_EOL;
}

$keranjang->pinjamSemua();
echo PHP_EOL . "pinjamSemua() berhasil, status berubah menjadi:" . PHP_EOL . PHP_EOL;
echo $keranjang->ringkasan() . PHP_EOL;

try {
    $ruangKuliah->pinjam();
} catch (RuntimeException $e) {
    echo PHP_EOL . "pinjam() kedua ditolak: " . $e->getMessage() . PHP_EOL;
}

$keranjang->kembalikanSemua();
echo PHP_EOL . "kembalikanSemua() berhasil, status kembali menjadi:" . PHP_EOL . PHP_EOL;
echo $keranjang->ringkasan() . PHP_EOL;

try {
    $ruangKuliah->kembalikan();
} catch (RuntimeException $e) {
    echo PHP_EOL . "kembalikan() saat ruang tersedia ditolak: " . $e->getMessage() . PHP_EOL;
}

try {
    new RuangKuliah("", "Ruang Tanpa Kode", 20);
} catch (InvalidArgumentException $e) {
    echo PHP_EOL . "Objek dengan kode kosong ditolak: " . $e->getMessage() . PHP_EOL;
}

try {
    new Peralatan("KAM-01", "Kamera", 0);
} catch (InvalidArgumentException $e) {
    echo "Objek dengan biaya nol ditolak: " . $e->getMessage() . PHP_EOL;
}

try {
    new KeranjangPinjaman("   ");
} catch (InvalidArgumentException $e) {
    echo "Keranjang tanpa nama ditolak: " . $e->getMessage() . PHP_EOL;
}

judul("6. HASIL AKHIR");

echo "Jumlah item di keranjang : " . $keranjang->jumlahItem() . PHP_EOL;
echo "Total tarif per jam      : " . rupiah($keranjang->totalBiaya()) . PHP_EOL;
echo "Semua item tersedia      : " . ($keranjang->semuaTersedia() ? "ya" : "tidak") . PHP_EOL;
