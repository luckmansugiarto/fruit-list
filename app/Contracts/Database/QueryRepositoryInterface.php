<?php

namespace App\Contracts\Database;

use Illuminate\Support\Collection;

interface QueryRepositoryInterface
{
    public function findAll(array $filters): Collection;

    public function findById($id);
}