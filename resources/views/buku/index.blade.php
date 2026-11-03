@extends('layouts.app')

@section('judul', 'Daftar Buku')

@section('konten')
    <div class="kepala-halaman">
        <p class="label-atas">Katalog</p>
        <h1>Daftar Buku</h1>
        <p class="keterangan">
            Delapan judul tersedia. Setiap judul dapat dibuka untuk melihat penulis,
            tahun terbit, dan jumlah eksemplar.
        </p>
    </div>

    <div class="kartu-ringkas">
        <div class="kartu">
            <span class="kartu-label">Judul buku</span>
            <span class="kartu-nilai">{{ $ringkasan['jumlahJudul'] }}</span>
        </div>
        <div class="kartu">
            <span class="kartu-label">Total eksemplar</span>
            <span class="kartu-nilai">{{ $ringkasan['jumlahStok'] }}</span>
        </div>
        <div class="kartu">
            <span class="kartu-label">Kategori</span>
            <span class="kartu-nilai">{{ $ringkasan['jumlahKategori'] }}</span>
        </div>
    </div>

    @if (count($daftarBuku) === 0)
        <p class="kosong">Belum ada buku yang terdaftar di katalog.</p>
    @else
        <div class="panel">
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 56px;">ID</th>
                        <th>Judul dan penulis</th>
                        <th style="width: 150px;">Kategori</th>
                        <th style="width: 90px;" class="kanan">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarBuku as $buku)
                        <tr>
                            <td>{{ $buku['id'] }}</td>
                            <td>
                                <a class="judul-buku" href="{{ route('buku.show', $buku['id']) }}">
                                    {{ $buku['judul'] }}
                                </a>
                                <span class="meta">{{ $buku['penulis'] }}, {{ $buku['tahun'] }}</span>
                            </td>
                            <td><span class="chip">{{ $buku['kategori'] }}</span></td>
                            <td class="kanan">{{ $buku['stok'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
