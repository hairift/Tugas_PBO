# Tugas 5 - Advanced OOP

Mini application OOP untuk kasus **Sistem Peminjaman Ruang Kelas**, melanjutkan
class `RuangKelas` dari Tugas 3 dan Tugas 4.

Mata kuliah: Pemrograman Berorientasi Objek (TI033015)
Program studi: Teknik Informatika, Universitas Catur Insan Cendekia
Penyusun: Muhammad Arif Triyana (20251020011)

## Masalah

Kampus memiliki beberapa jenis ruang dengan aturan yang tidak sama. Ruang kuliah
diajukan lewat bagian akademik, laboratorium diajukan lewat kepala laboratorium
dan wajib didampingi laboran, sedangkan ruang diskusi dipesan sendiri lewat
aplikasi kampus. Tarif per jamnya juga berbeda. Selain ruang, mahasiswa sering
meminjam peralatan seperti proyektor dan laptop pada waktu yang bersamaan.

Program sebelumnya hanya memiliki satu class `RuangKelas`, sehingga semua ruang
dianggap sama. Akibatnya aturan dan tarif harus ditulis sebagai percabangan di
kode pemanggil, dan setiap kali muncul jenis ruang baru kode pemanggil ikut
diubah. Tugas ini menyusun ulang model tersebut supaya jenis objek baru dapat
ditambahkan tanpa menyentuh kode pemanggil.

## Desain

```mermaid
classDiagram
    class BisaDipinjam {
        <<interface>>
        +getKode()
        +getNama()
        +biayaSewa()
        +isTersedia()
        +pinjam()
        +kembalikan()
    }

    class Ruang {
        <<abstract>>
        #kodeRuang
        #namaRuang
        #kapasitas
        #status
        +caraAkses()
        +biayaSewa()
        +syaratTambahan()
    }

    class RuangKuliah
    class Laboratorium
    class RuangDiskusi

    class Peralatan {
        -kode
        -nama
        -biayaPerJam
        -tersedia
    }

    class KeranjangPinjaman {
        -namaPeminjam
        -items
        +tambah()
        +jumlahItem()
        +totalBiaya()
        +pinjamSemua()
        +kembalikanSemua()
        +ringkasan()
    }

    BisaDipinjam <|.. Ruang
    BisaDipinjam <|.. Peralatan
    Ruang <|-- RuangKuliah
    Ruang <|-- Laboratorium
    Ruang <|-- RuangDiskusi
    KeranjangPinjaman *-- BisaDipinjam
```

**Tabel 1. Peran setiap class**

| Class | Peran |
| --- | --- |
| `BisaDipinjam` | Interface. Kontrak untuk apa pun yang dapat dipinjam. |
| `Ruang` | Abstract class. Menyimpan kode, nama, kapasitas, status, dan aturan pinjam/kembali yang sama untuk semua ruang. |
| `RuangKuliah` | Ruang untuk perkuliahan, tarif Rp50.000 per jam. |
| `Laboratorium` | Ruang praktikum, tarif Rp120.000 per jam, punya syarat tambahan. |
| `RuangDiskusi` | Ruang diskusi mahasiswa, tarif Rp25.000 per jam. |
| `Peralatan` | Barang yang dipinjam bersama ruang, misalnya proyektor dan laptop. |
| `KeranjangPinjaman` | Wadah yang menyusun beberapa item menjadi satu pengajuan peminjaman. |

## Alasan pilihan relasi

1. **Inheritance dipakai untuk jenis ruang.** `RuangKuliah`, `Laboratorium`, dan
   `RuangDiskusi` benar-benar "adalah" sebuah `Ruang`. Ketiganya memakai kode,
   nama, kapasitas, status, dan aturan pinjam/kembali yang identik. Yang berbeda
   hanya cara akses dan tarif. Karena hubungannya is-a dan perilaku dasarnya
   memang layak dipakai ulang, inheritance adalah pilihan yang tepat. Inheritance
   tidak dipakai semata-mata untuk menghindari duplikasi beberapa baris kode.

2. **Interface dipakai untuk kemampuan meminjam.** Proyektor bukan ruang, jadi
   tidak mungkin mewarisi `Ruang`. Yang sama antara ruang dan peralatan bukan
   strukturnya, melainkan kemampuannya, yaitu bisa dipinjam, punya kode, dan
   punya tarif. Hubungan seperti ini adalah can-do, sehingga bentuk yang benar
   adalah interface. Karena `KeranjangPinjaman` menerima `BisaDipinjam`, keranjang
   dapat menampung ruang dan peralatan sekaligus tanpa memeriksa class-nya.

3. **Composition dipakai untuk keranjang.** `KeranjangPinjaman` bukan salah satu
   jenis `BisaDipinjam`, melainkan wadah yang berisi banyak item. Hubungannya
   has-a. Composition dipilih karena isi keranjang harus dapat ditambah dan
   diganti saat program berjalan, dan keranjang tidak perlu mewarisi apa pun dari
   item yang disimpannya.

4. **Kenapa tidak semuanya inheritance.** Bila `Peralatan` dipaksa
   `extends Ruang`, ia akan menerima kapasitas dan cara akses yang tidak masuk
   akal untuk sebuah proyektor. Bila `KeranjangPinjaman` mewarisi item, keranjang
   justru menjadi salah satu item, padahal tugasnya menyimpan item.

## Overriding dan polymorphism

`caraAkses()` dan `biayaSewa()` dideklarasikan abstract pada `Ruang`, sehingga
setiap subclass wajib memberi implementasi sendiri. `syaratTambahan()` berbeda:
method ini sudah punya isi default berupa array kosong, dan hanya `Laboratorium`
yang meng-override-nya. Dua bentuk ini sengaja ditunjukkan bersama supaya
terlihat bedanya antara method yang wajib diwujudkan dan method yang boleh
diwarisi apa adanya.

Polymorphism muncul di dua tempat. `cetakTarif(BisaDipinjam $item)` memanggil
`biayaSewa()` pada lima objek dari dua hierarki berbeda dan hasilnya menyesuaikan
masing-masing objek. `cetakCaraAkses(Ruang $ruang)` memanggil `caraAkses()` pada
tiga jenis ruang. Keduanya tidak memuat satu pun `if` yang memeriksa nama class.

## Cara menjalankan

```bash
php index.php
```

Program tidak memerlukan database, Composer, atau pustaka tambahan. Cukup PHP 7.4
ke atas karena kode memakai typed property.

## Hasil pengujian

Keluaran program dibagi menjadi enam bagian.

**Tabel 2. Bagian keluaran program**

| Bagian | Yang dibuktikan |
| --- | --- |
| 1 | Aturan tiap jenis ruang berbeda, termasuk syarat tambahan laboratorium. |
| 2 | Satu fungsi `cetakTarif()` menghasilkan tarif berbeda untuk lima objek. |
| 3 | Satu fungsi `cetakCaraAkses()` menghasilkan cara akses berbeda untuk tiga jenis ruang. |
| 4 | Keranjang menampung tiga item berbeda dan menghitung total tarifnya. |
| 5 | Penolakan berjalan: item ganda, pinjam dua kali, kembalikan saat tersedia, kode kosong, biaya nol, dan nama peminjam kosong. |
| 6 | Keadaan akhir: tiga item, total Rp90.000 per jam, semuanya tersedia. |

## Dokumentasi

Tangkapan layar diambil langsung dari VS Code dan PowerShell saat program
dijalankan. Semua berkas disimpan di folder `docs/` dan diberi nomor sesuai
urutan pembahasan, sehingga Gambar 1 selalu `docs/01-index-1.png` dan seterusnya.
Gambar di dalam tabel sengaja diperkecil agar tetap rapi, sedangkan berkas asli
berukuran penuh tersimpan di folder tersebut dengan nama seperti yang tertulis
di bawah setiap gambar.

**Tabel 3. Tangkapan layar source code**

| No | Gambar | Keterangan |
| :--: | :-- | :-- |
| 1 | <img src="docs/01-index-1.png" width="330"><br>`01-index-1.png` | `index.php` baris 1-36. Pemuatan tujuh class, helper `judul()` dan `rupiah()`, fungsi `cetakTarif()` dan `cetakCaraAkses()` yang hanya mengenal tipe, serta pembuatan objek yang diuji. |
| 2 | <img src="docs/02-index-2.png" width="330"><br>`02-index-2.png` | `index.php` baris 37-72. Bagian 1 mencetak aturan tiap jenis ruang, bagian 2 dan 3 menunjukkan polymorphism pada interface dan abstract class, bagian 4 mulai menyusun keranjang. |
| 3 | <img src="docs/03-index-3.png" width="330"><br>`03-index-3.png` | `index.php` baris 73-107. Bagian 5 menguji penolakan item ganda dan peminjaman kedua, lalu pengembalian seluruh item. |
| 4 | <img src="docs/04-index-4.png" width="330"><br>`04-index-4.png` | `index.php` baris 109-129. Sisa penolakan, yaitu kode kosong, biaya nol, dan nama peminjam kosong, lalu bagian 6 yang mencetak keadaan akhir. |
| 5 | <img src="docs/05-bisadipinjam.png" width="330"><br>`05-bisadipinjam.png` | `BisaDipinjam.php` utuh. Enam method kontrak yang wajib dipenuhi setiap objek yang dapat dipinjam. |
| 6 | <img src="docs/06-keranjang-1.png" width="330"><br>`06-keranjang-1.png` | `KeranjangPinjaman.php` baris 1-36. Konstanta lebar pemisah, property, constructor yang menolak nama kosong, dan awal `tambah()`. |
| 7 | <img src="docs/07-keranjang-2.png" width="330"><br>`07-keranjang-2.png` | `KeranjangPinjaman.php` baris 29-69. Penolakan kode ganda, `jumlahItem()`, `totalBiaya()`, `semuaTersedia()`, dan awal `pinjamSemua()`. |
| 8 | <img src="docs/08-keranjang-3.png" width="330"><br>`08-keranjang-3.png` | `KeranjangPinjaman.php` baris 69-103. `pinjamSemua()` yang berlaku semua atau tidak sama sekali, `kembalikanSemua()`, dan awal `ringkasan()`. |
| 9 | <img src="docs/09-keranjang-4.png" width="330"><br>`09-keranjang-4.png` | `KeranjangPinjaman.php` baris 104-112. Penutup `ringkasan()` yang menyusun baris tabel dengan `sprintf`. |
| 10 | <img src="docs/10-laboratorium.png" width="330"><br>`10-laboratorium.png` | `Laboratorium.php` utuh. Override `caraAkses()`, `biayaSewa()`, dan `syaratTambahan()`. |
| 11 | <img src="docs/11-peralatan-1.png" width="330"><br>`11-peralatan-1.png` | `Peralatan.php` baris 1-37. Konstanta, property, dan validasi constructor. Status disimpan sebagai boolean, bukan string seperti pada `Ruang`. |
| 12 | <img src="docs/12-peralatan-2.png" width="330"><br>`12-peralatan-2.png` | `Peralatan.php` baris 38-72. Getter, `biayaSewa()`, `isTersedia()`, `pinjam()`, dan awal `kembalikan()`. |
| 13 | <img src="docs/13-peralatan-3.png" width="330"><br>`13-peralatan-3.png` | `Peralatan.php` baris 72-77. Penutup `kembalikan()`. |
| 14 | <img src="docs/14-ruang-1.png" width="330"><br>`14-ruang-1.png` | `Ruang.php` baris 1-37. Konstanta aturan, property protected, constructor, dan awal getter. |
| 15 | <img src="docs/15-ruang-2.png" width="330"><br>`15-ruang-2.png` | `Ruang.php` baris 35-69. Getter, `isTersedia()`, `pinjam()`, `kembalikan()`, dan deklarasi dua method abstract. |
| 16 | <img src="docs/16-ruang-3.png" width="330"><br>`16-ruang-3.png` | `Ruang.php` baris 71-105. `syaratTambahan()` dengan isi default, `setKodeRuang()`, `setNamaRuang()`, dan awal `setKapasitas()`. |
| 17 | <img src="docs/17-ruang-4.png" width="330"><br>`17-ruang-4.png` | `Ruang.php` baris 106-120. Penutup `setKapasitas()` dan `ubahStatus()` yang menjaga daftar status. |
| 18 | <img src="docs/18-ruangdiskusi.png" width="330"><br>`18-ruangdiskusi.png` | `RuangDiskusi.php` utuh. Subclass paling ringkas, hanya mengisi `caraAkses()` dan `biayaSewa()`. |
| 19 | <img src="docs/19-ruang-kuliah.png" width="330"><br>`19-ruang-kuliah.png` | `RuangKuliah.php` utuh. Subclass pertama yang mewarisi seluruh aturan dasar `Ruang`. |

**Tabel 4. Tangkapan layar keluaran program**

| No | Gambar | Keterangan |
| :--: | :-- | :-- |
| 20 | <img src="docs/20-keluaran-lengkap.png" width="330"><br>`20-keluaran-lengkap.png` | Seluruh keluaran program dalam satu tampilan, dari bagian 1 sampai bagian 6. |
| 21 | <img src="docs/21-keluaran-1.png" width="330"><br>`21-keluaran-1.png` | Keluaran bagian 1 sampai 3. Aturan tiap jenis ruang, lalu dua contoh polymorphism. |
| 22 | <img src="docs/22-keluaran-2.png" width="330"><br>`22-keluaran-2.png` | Keluaran bagian 3 sampai 5. Cara akses tiap ruang, isi keranjang, dan penolakan item ganda. |
| 23 | <img src="docs/23-keluaran-3.png" width="330"><br>`23-keluaran-3.png` | Keluaran bagian 5 dan 6. Sisa penolakan, keadaan akhir, dan prompt kembali. |

## Struktur berkas

```
index.php                    demo dan pengujian
src/BisaDipinjam.php         interface
src/Ruang.php                abstract class
src/RuangKuliah.php          subclass
src/Laboratorium.php         subclass
src/RuangDiskusi.php         subclass
src/Peralatan.php            implementasi interface di luar hierarki Ruang
src/KeranjangPinjaman.php    composition
docs/                        tangkapan layar source code dan keluaran program
README.md                    berkas ini
REFLEKSI.md                  refleksi pengerjaan
```
