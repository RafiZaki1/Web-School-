<?php

namespace App\Contracts\Interfaces;

interface StatisticRepositoryInterface
{
    public function getCounts(): array;

    public function establishedYear(): ?int;
}
