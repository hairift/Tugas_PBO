<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    public function index()
    {
        $daftarBuku = $this->daftarBuku();

        $ringkasan = [
            'jumlahJudul' => count($daftarBuku),
            'jumlahStok' => array_sum(array_column($daftarBuku, 'stok')),
            'jumlahKategori' => count(array_unique(array_column($daftarBuku, 'kategori'))),
        ];

        return view('buku.index', compact('daftarBuku', 'ringkasan'));
    }

    public function show(string $id)
    {
        $buku = collect($this->daftarBuku())->firstWhere('id', (int) $id);

        abort_if($buku === null, 404, 'Buku dengan ID ' . $id . ' tidak ada di katalog.');

        return view('buku.show', compact('buku'));
    }

    // Data contoh disiapkan di controller supaya route tetap ringkas.
    private function daftarBuku(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Belajar PHP',
                'penulis' => 'Andi Prasetyo',
                'tahun' => 2021,
                'kategori' => 'Pemrograman',
                'stok' => 4,
                'ringkasan' => 'Pengantar sintaks PHP mulai dari variabel, percabangan, '
                    . 'perulangan, sampai fungsi dan penanganan form.',
            ],
            [
                'id' => 2,
                'judul' => 'Dasar Laravel',
                'penulis' => 'Budi Santosa',
                'tahun' => 2023,
                'kategori' => 'Pemrograman',
                'stok' => 3,
                'ringkasan' => 'Membahas pemasangan Laravel, struktur proyek, routing, '
                    . 'controller, dan Blade untuk pemula.',
            ],
            [
                'id' => 3,
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Rina Kusumawati',
                'tahun' => 2020,
                'kategori' => 'Informatika',
                'stok' => 5,
                'ringkasan' => 'Membandingkan algoritma pencarian dan pengurutan beserta '
                    . 'kompleksitas waktunya.',
            ],
            [
                'id' => 4,
                'judul' => 'Basis Data Relasional',
                'penulis' => 'Sinta Maharani',
                'tahun' => 2022,
                'kategori' => 'Informatika',
                'stok' => 2,
                'ringkasan' => 'Perancangan tabel, kunci primer dan asing, normalisasi, '
                    . 'serta query SQL dasar.',
            ],
            [
                'id' => 5,
                'judul' => 'Pemrograman Berorientasi Objek',
                'penulis' => 'Yusuf Hidayat',
                'tahun' => 2024,
                'kategori' => 'Informatika',
                'stok' => 6,
                'ringkasan' => 'Class, objek, enkapsulasi, pewarisan, interface, dan '
                    . 'penerapannya pada studi kasus peminjaman ruang kelas.',
            ],
            [
                'id' => 6,
                'judul' => 'Jaringan Komputer',
                'penulis' => 'Dedi Kurniawan',
                'tahun' => 2019,
                'kategori' => 'Infrastruktur',
                'stok' => 3,
                'ringkasan' => 'Model OSI, pengalamatan IP, subnetting, dan dasar '
                    . 'konfigurasi jaringan lokal.',
            ],
            [
                'id' => 7,
                'judul' => 'Interaksi Manusia dan Komputer',
                'penulis' => 'Maya Lestari',
                'tahun' => 2021,
                'kategori' => 'Desain',
                'stok' => 2,
                'ringkasan' => 'Prinsip usability, perancangan antarmuka, dan evaluasi '
                    . 'pengalaman pengguna.',
            ],
            [
                'id' => 8,
                'judul' => 'Kecerdasan Buatan',
                'penulis' => 'Fajar Ramadhan',
                'tahun' => 2024,
                'kategori' => 'Informatika',
                'stok' => 4,
                'ringkasan' => 'Pencarian heuristik, representasi pengetahuan, dan '
                    . 'pengantar pembelajaran mesin.',
            ],
        ];
    }
}
