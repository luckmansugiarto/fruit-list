<?php

namespace App\Contracts\DataStructure;

use Illuminate\Support\Collection;

interface ParentReferenceTree
{
    public function constructHierarchy(Collection $data, int $depth): array;

    public function flattenHierarchy(array $data, string $parent, int $depth, array $outcome): array;
}