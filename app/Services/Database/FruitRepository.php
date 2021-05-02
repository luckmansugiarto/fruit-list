<?php
namespace App\Services\Database;

use App\Models\Fruit;
use App\Services\Database\BaseEloquentRepository;

class FruitRepository extends BaseEloquentRepository
{
    public function __construct(Fruit $fruitModel)
    {
        parent::__construct($fruitModel);
    }

    public function bulkSave(array $data): bool
    {
        if (count($data) > 0)
        {
            $existingDbData = $this->model->from(function ($q) {
                    $q->selectRaw("CONCAT(LOWER(label), '_', depth) AS dkey, id, label, parent_id, depth, deleted_at")
                        ->from($this->model->getTable())
                        ->whereNull('deleted_at');
                }, 'f')
                ->whereIn('f.dkey', array_keys(array_change_key_case($data, CASE_LOWER)))
                ->withTrashed()
                ->orderBy('f.label')
                ->get()
                ->keyBy('dkey')
                ->toArray();

            // Leave existing DB data as is, that is, don't modify it with the entry found in the given source data.
            $newData = array_diff_key($data, $existingDbData);

            foreach ($newData as $key => $details)
            {
                $parentId = null;

                if (!is_null($details['parent']))
                {
                    if (isset($newData[$details['parent']]))
                    {
                        $parentId = $newData[$details['parent']]['id'] ?? null;
                    }

                    if (isset($existingDbData[$details['parent']]))
                    {
                        $parentId = $existingDbData[$details['parent']]['id'] ?? null;
                    }

                    if (is_null($parentId))
                    {
                        continue;
                    }
                }

                $details['parent_id'] = $parentId;
                $newModel = new $this->model($details);

                if ($newModel->save())
                {
                    $newData[$key]['id'] = $newModel->id;
                }
            }
        }

        return true;
    }
}