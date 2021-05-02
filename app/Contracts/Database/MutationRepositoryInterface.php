<?php

namespace App\Contracts\Database;

interface MutationRepositoryInterface
{
    public function save(array $attributes): bool;

    public function update(array $attributes): bool;
}