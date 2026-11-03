@extends('layouts.app')

@section('judul', $buku['judul'])

@section('konten')
    <p class="remah">
        <a href="{{ route('buku.index') }}">Daftar Buku</a> / Detail Buku
    </p>

    <div class="isi-detail">
        <p class="label-atas">{{ $buku['kategori'] }}</p>
        <h1>{{ $buku['judul'] }}</h1>
        <p class="keterangan">{{ $buku['ringkasan'] }}</p>

        <dl class="rincian">
            <dt>ID Buku</dt>
            <dd>{{ $buku['id'] }}</dd>

            <dt>Penulis</dt>
            <dd>{{ $buku['penulis'] }}</dd>

            <dt>Tahun terbit</dt>
            <dd>{{ $buku['tahun'] }}</dd>

            <dt>Stok</dt>
            <dd>{{ $buku['stok'] }} eksemplar</dd>
        </dl>

        @if ($buku['stok'] > 0)
            <span class="status status-tersedia">Tersedia untuk dipinjam</span>
        @else
            <span class="status status-habis">Stok habis, semua eksemplar sedang dipinjam</span>
        @endif

        <div>
            <a class="tombol tombol-ringan" href="{{ route('buku.index') }}">Kembali ke daftar</a>
        </div>
    </div>
@endsection
