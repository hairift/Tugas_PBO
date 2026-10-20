<?php

declare(strict_types=1);

interface BisaDipinjam
{
    public function getKode(): string;

    public function getNama(): string;

    public function biayaSewa(): int;

    public function isTersedia(): bool;

    public function pinjam(): void;

    public function kembalikan(): void;
}
