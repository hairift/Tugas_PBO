<?php

declare(strict_types=1);

class Laboratorium extends Ruang
{
    public function caraAkses(): string
    {
        return "Diajukan ke kepala laboratorium";
    }

    public function biayaSewa(): int
    {
        return 120000;
    }

    public function syaratTambahan(): array
    {
        return [
            "Wajib didampingi laboran",
            "Maksimal 30 praktikan",
        ];
    }
}
