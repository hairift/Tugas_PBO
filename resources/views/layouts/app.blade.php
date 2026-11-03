<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Perpustakaan Kampus')</title>
    <link rel="stylesheet" href="{{ asset('css/pbo.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="topbar-dalam">
            <a href="{{ url('/') }}" class="merek">
                <span class="merek-tanda">PBO</span>
                <span>Perpustakaan Kampus</span>
            </a>
            <nav class="navigasi">
                <a href="{{ route('buku.index') }}"
                   class="@if (request()->routeIs('buku.*')) aktif @endif">Buku</a>
                <a href="{{ route('anggota.index') }}"
                   class="@if (request()->routeIs('anggota.*')) aktif @endif">Anggota</a>
            </nav>
        </div>
    </header>

    <main class="wadah">
        @yield('konten')
    </main>

    <footer class="kaki">
        Pemrograman Berorientasi Objek TI033015, Universitas Catur Insan Cendekia
    </footer>
</body>
</html>
