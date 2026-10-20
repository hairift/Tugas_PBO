<?php

declare(strict_types=1);

class RuangKuliah extends Ruang
{
    public function caraAkses(): string
    {
        return "Diajukan ke bagian akademik minimal satu hari sebelumnya";
    }

    public function biayaSewa(): int
    {
        return 50000;
    }
}
