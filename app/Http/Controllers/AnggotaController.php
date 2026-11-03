<?php

namespace App\Http\Controllers;

class AnggotaController extends Controller
{
    public function index()
    {
        $daftarAnggota = $this->daftarAnggota();

        $ringkasan = [
            'jumlahAnggota' => count($daftarAnggota),
            'jumlahAktif' => count(array_filter(
                $daftarAnggota,
                fn (array $anggota) => $anggota['status'] === 'Aktif'
            )),
            'jumlahPinjaman' => array_sum(array_map(
                fn (array $anggota) => count($anggota['pinjaman']),
                $daftarAnggota
            )),
        ];

        return view('anggota.index', compact('daftarAnggota', 'ringkasan'));
    }

    public function show(string $id)
    {
        $anggota = collect($this->daftarAnggota())->firstWhere('id', (int) $id);

        abort_if($anggota === null, 404, 'Anggota dengan ID ' . $id . ' tidak terdaftar.');

        $jumlahPinjaman = count($anggota['pinjaman']);

        return view('anggota.show', compact('anggota', 'jumlahPinjaman'));
    }

    // Data contoh anggota perpustakaan, belum memakai database.
    private function daftarAnggota(): array
    {
        return [
            [
                'id' => 1,
                'nama' => 'Aditya Nugraha',
                'nim' => '20251010021',
                'prodi' => 'Teknik Informatika',
                'angkatan' => 2025,
                'status' => 'Aktif',
                'terdaftar' => '12 September 2025',
                'pinjaman' => [
                    ['judul' => 'Dasar Laravel', 'tanggal' => '28 Oktober 2026'],
                    ['judul' => 'Basis Data Relasional', 'tanggal' => '30 Oktober 2026'],
                ],
            ],
            [
                'id' => 2,
                'nama' => 'Bella Kartika',
                'nim' => '20251010034',
                'prodi' => 'Teknik Informatika',
                'angkatan' => 2025,
                'status' => 'Aktif',
                'terdaftar' => '15 September 2025',
                'pinjaman' => [
                    ['judul' => 'Belajar PHP', 'tanggal' => '2 November 2026'],
                ],
            ],
            [
                'id' => 3,
                'nama' => 'Chandra Wijaya',
                'nim' => '20241020008',
                'prodi' => 'Sistem Informasi',
                'angkatan' => 2024,
                'status' => 'Aktif',
                'terdaftar' => '3 September 2024',
                'pinjaman' => [],
            ],
            [
                'id' => 4,
                'nama' => 'Dinda Prameswari',
                'nim' => '20241020019',
                'prodi' => 'Sistem Informasi',
                'angkatan' => 2024,
                'status' => 'Nonaktif',
                'terdaftar' => '5 September 2024',
                'pinjaman' => [],
            ],
            [
                'id' => 5,
                'nama' => 'Eka Saputra',
                'nim' => '20231010012',
                'prodi' => 'Teknik Informatika',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'terdaftar' => '7 September 2023',
                'pinjaman' => [
                    ['judul' => 'Algoritma dan Struktur Data', 'tanggal' => '21 Oktober 2026'],
                    ['judul' => 'Kecerdasan Buatan', 'tanggal' => '26 Oktober 2026'],
                    ['judul' => 'Jaringan Komputer', 'tanggal' => '1 November 2026'],
                ],
            ],
            [
                'id' => 6,
                'nama' => 'Farah Nabila',
                'nim' => '20231010027',
                'prodi' => 'Teknik Informatika',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'terdaftar' => '11 September 2023',
                'pinjaman' => [
                    ['judul' => 'Interaksi Manusia dan Komputer', 'tanggal' => '31 Oktober 2026'],
                ],
            ],
            [
                'id' => 7,
                'nama' => 'Gilang Ramadhan',
                'nim' => '20221010005',
                'prodi' => 'Teknik Informatika',
                'angkatan' => 2022,
                'status' => 'Nonaktif',
                'terdaftar' => '9 September 2022',
                'pinjaman' => [],
            ],
            [
                'id' => 8,
                'nama' => 'Hana Maulida',
                'nim' => '20251010041',
                'prodi' => 'Sistem Informasi',
                'angkatan' => 2025,
                'status' => 'Aktif',
                'terdaftar' => '18 September 2025',
                'pinjaman' => [
                    ['judul' => 'Pemrograman Berorientasi Objek', 'tanggal' => '29 Oktober 2026'],
                ],
            ],
        ];
    }
}
