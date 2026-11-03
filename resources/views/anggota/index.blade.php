@extends('layouts.app')

@section('judul', 'Daftar Anggota')

@section('konten')
    <div class="kepala-halaman">
        <p class="label-atas">Keanggotaan</p>
        <h1>Daftar Anggota Perpustakaan</h1>
        <p class="keterangan">
            Delapan anggota terdaftar. Kolom status menunjukkan keaktifan, kolom
            terakhir menunjukkan jumlah buku yang dipinjam.
        </p>
    </div>

    <div class="kartu-ringkas">
        <div class="kartu">
            <span class="kartu-label">Total anggota</span>
            <span class="kartu-nilai">{{ $ringkasan['jumlahAnggota'] }}</span>
        </div>
        <div class="kartu">
            <span class="kartu-label">Status aktif</span>
            <span class="kartu-nilai">{{ $ringkasan['jumlahAktif'] }}</span>
        </div>
        <div class="kartu">
            <span class="kartu-label">Pinjaman berjalan</span>
            <span class="kartu-nilai">{{ $ringkasan['jumlahPinjaman'] }}</span>
        </div>
    </div>

    <div class="panel">
        <table class="tabel">
            <thead>
                <tr>
                    <th style="width: 56px;">ID</th>
                    <th>Nama dan NIM</th>
                    <th style="width: 190px;">Program studi</th>
                    <th style="width: 110px;">Status</th>
                    <th style="width: 90px;" class="kanan">Pinjaman</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarAnggota as $anggota)
                    <tr>
                        <td>{{ $anggota['id'] }}</td>
                        <td>
                            <a class="judul-buku" href="{{ route('anggota.show', $anggota['id']) }}">
                                {{ $anggota['nama'] }}
                            </a>
                            <span class="meta">{{ $anggota['nim'] }}</span>
                        </td>
                        <td>
                            {{ $anggota['prodi'] }}
                            <span class="meta">Angkatan {{ $anggota['angkatan'] }}</span>
                        </td>
                        <td>
                            @if ($anggota['status'] === 'Aktif')
                                <span class="chip chip-hijau">Aktif</span>
                            @else
                                <span class="chip chip-merah">Nonaktif</span>
                            @endif
                        </td>
                        <td class="kanan">{{ count($anggota['pinjaman']) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            Belum ada anggota yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
