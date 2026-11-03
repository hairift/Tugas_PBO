@extends('layouts.app')

@section('judul', $anggota['nama'])

@section('konten')
    <p class="remah">
        <a href="{{ route('anggota.index') }}">Daftar Anggota</a> / Detail Anggota
    </p>

    <div class="isi-detail">
        <p class="label-atas">Kartu Anggota</p>
        <h1>{{ $anggota['nama'] }}</h1>

        @if ($anggota['status'] === 'Aktif')
            <span class="status status-tersedia">Status keanggotaan aktif</span>
        @else
            <span class="status status-habis">Status keanggotaan nonaktif</span>
        @endif

        <dl class="rincian">
            <dt>ID Anggota</dt>
            <dd>{{ $anggota['id'] }}</dd>

            <dt>NIM</dt>
            <dd>{{ $anggota['nim'] }}</dd>

            <dt>Program studi</dt>
            <dd>{{ $anggota['prodi'] }}</dd>

            <dt>Angkatan</dt>
            <dd>{{ $anggota['angkatan'] }}</dd>

            <dt>Terdaftar</dt>
            <dd>{{ $anggota['terdaftar'] }}</dd>

            <dt>Pinjaman aktif</dt>
            <dd>{{ $jumlahPinjaman }} buku</dd>
        </dl>

        <h2>Buku yang sedang dipinjam</h2>

        @if ($jumlahPinjaman === 0)
            <p class="kosong">Tidak ada pinjaman yang sedang berjalan.</p>
        @else
            <ul class="daftar-pinjaman">
                @foreach ($anggota['pinjaman'] as $pinjaman)
                    <li>
                        <span class="tanggal">{{ $pinjaman['tanggal'] }}</span>
                        {{ $pinjaman['judul'] }}
                    </li>
                @endforeach
            </ul>
        @endif

        <div style="margin-top: 26px;">
            <a class="tombol tombol-ringan" href="{{ route('anggota.index') }}">Kembali ke daftar</a>
        </div>
    </div>
@endsection
