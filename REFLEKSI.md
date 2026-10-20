# Refleksi Pengerjaan Tugas 5

## Bagian yang paling sulit

Bagian tersulit bukan menulis sintaks `extends` atau `implements`, melainkan
memutuskan relasi mana yang dipakai untuk tiap class. Awalnya `Peralatan` sempat
saya rancang sebagai turunan `Ruang` karena keduanya sama-sama bisa dipinjam.
Rancangan itu salah. Proyektor tidak punya kapasitas orang dan tidak punya cara
akses ruang, sehingga warisan itu memaksa `Peralatan` membawa properti yang tidak
bermakna. Setelah dipisahkan, barulah terlihat bahwa yang sama antara keduanya
adalah kemampuan, bukan struktur. Di situ interface menjadi jawaban yang tepat.

## Keputusan desain yang saya ambil

1. `caraAkses()` dan `biayaSewa()` dibuat abstract karena setiap jenis ruang
   memang wajib punya jawaban sendiri. Kalau diberi nilai default, subclass yang
   lupa mengisi akan lolos tanpa ketahuan.

2. `syaratTambahan()` justru diberi isi default berupa array kosong. Sebagian
   besar ruang tidak punya syarat khusus, jadi memaksanya abstract hanya akan
   membuat `RuangKuliah` dan `RuangDiskusi` menulis method kosong yang sama.

3. Tampilan dipindahkan keluar dari model. Pada Tugas 4, `tampilkanInfo()` masih
   memakai `echo` dan saya pertahankan karena belum ada lapisan yang menampungnya.
   Pada tugas ini muncul `KeranjangPinjaman` yang harus menyusun keluaran dari
   banyak objek sekaligus, sehingga `echo` di dalam model justru mengganggu.
   Karena itu ruang sekarang hanya menyimpan data dan aturan, sedangkan
   penyusunan teks dilakukan oleh keranjang.

4. `pinjamSemua()` memeriksa ketersediaan seluruh item lebih dulu, baru meminjam.
   Tanpa pemeriksaan di depan, item pertama bisa sudah terpinjam ketika item
   ketiga gagal, dan keranjang berakhir setengah jadi.

## Yang belum dijaga

1. Program belum memeriksa bentrok jadwal. Dua peminjam pada jam yang sama masih
   bisa sama-sama berhasil, karena model ini hanya menyimpan status, bukan waktu.
2. Biaya masih berupa tarif per jam, belum dikalikan durasi pemakaian.
3. Tidak ada penyimpanan permanen. Data hanya hidup selama program berjalan,
   sesuai batasan tugas yang tidak meminta database.

Ketiganya bukan kelalaian, melainkan hal yang sengaja tidak dimasukkan supaya
lingkup tugas tetap pada kualitas model OOP.

## Yang saya pelajari

Polymorphism baru terasa gunanya ketika kode pemanggil benar-benar tidak perlu
tahu objek apa yang sedang dipegang. Sebelumnya saya cenderung menulis `if` untuk
memeriksa jenis objek. Setelah `cetakTarif(BisaDipinjam $item)` selesai, fungsi
itu tidak berubah sama sekali ketika saya menambahkan `Peralatan` sebagai jenis
kedua. Di situlah bedanya menambah class baru dengan mengubah kode lama.
