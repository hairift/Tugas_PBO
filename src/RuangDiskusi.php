<?php

declare(strict_types=1);

class RuangDiskusi extends Ruang
{
    public function caraAkses(): string
    {
        return "Dipesan mandiri melalui aplikasi kampus";
    }

    public function biayaSewa(): int
    {
        return 25000;
    }
}
