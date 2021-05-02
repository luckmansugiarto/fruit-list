<?php

namespace App\Contracts\Database;

interface BulkMutationRepositoryInterface
{
    public function bulkSave(array $data): bool;
}