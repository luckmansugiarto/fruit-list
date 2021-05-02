<?php

namespace App\Services\DataStructure;

use App\Contracts\DataStructure\ParentReferenceTree;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FruitDataStructureService implements ParentReferenceTree
{
    public function constructHierarchy(Collection $data, int $depth = 0): array
    {
        if ($depth === 0)
        {
            $data = $data->sortBy(function ($item) {
                return $item['depth'] . '_' . $item['parent_id'] . '_' . $item['label'];
            });
        }

        $outcome = $data->where('depth', $depth)->reduce(function ($carry, $entry) {
            $carry[$entry['id']] = [
                'id' => $entry['id'],
                'label' => $entry['label'],
                'parent_id' => $entry['parent_id'],
                'children' => []
            ];

            return $carry;
        }, []);

        if (count($outcome) > 0)
        {
            $children = $this->constructHierarchy($data, $depth + 1);

            if (count($children) > 0)
            {
                foreach ($children as $childId => $childDetails)
                {
                    if (!is_null($childDetails['parent_id']) && isset($outcome[$childDetails['parent_id']]))
                    {
                        $outcome[$childDetails['parent_id']]['children'][] = $childDetails;
                    }
                }
            }
        }

        if ($depth === 0)
        {
            $outcome = array_values($outcome);
        }

        return $outcome;
    }

    public function flattenHierarchy(array $data, string $parent = null, int $depth = 0, array $result = []): array
    {
        foreach ($data as $idx => $entry)
        {
            $key = strtolower($entry['label']) . '_' . $depth;

            $result[$key] = [
                'label' => $entry['label'],
                'depth' => $depth,
                'parent' => $parent
            ];

            if (isset($entry['children']))
            {
                $result = $this->flattenHierarchy($entry['children'], $key, $depth+1, $result);
            }
        }

        return $result;
    }
}