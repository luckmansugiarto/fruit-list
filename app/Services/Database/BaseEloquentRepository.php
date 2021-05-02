<?php
namespace App\Services\Database;

use App\Contracts\Database\BulkMutationRepositoryInterface;
use App\Contracts\Database\MutationRepositoryInterface;
use App\Contracts\Database\QueryRepositoryInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

abstract class BaseEloquentRepository
    implements BulkMutationRepositoryInterface,
        MutationRepositoryInterface,
        QueryRepositoryInterface
{
    protected EloquentModel $model;

    public function __construct (EloquentModel $model)
    {
        $this->model = $model;
    }

    public function bulkSave(array $data): bool
    {
        // Concrete implementation should be done on child classes
        return true;
    }

    public function findAll(array $filter = []): Collection
    {
        $max = $filter['max'] ?? -1;
        $page = $filter['page'] ?? -1;
        $sortBy = $filter['sortBy'] ?? [];
        $hasFilter = false;
        $model = $this->model;

        if ($max > 0)
        {
            $hasFilter = true;

            if ($page > 0)
            {
                $model = $model->skip(($page - 1) * $max);
            }

            $model = $model->take($max);
        }

        if (count($sortBy) > 0)
        {
            $hasFilter = true;

            foreach ($sortBy as $attribute => $direction)
            {
                $model = $model->orderBy($attribute, $direction);
            }
        }

        if ($hasFilter === true)
        {
            return $model->get();
        }
        else
        {
            return $this->model->all();
        }
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function save(array $attributes): bool
    {
        return $this->model->save($attributes);
    }

    public function update(array $attributes): bool
    {
        $updateData = [];
        $totalSuccessfulUpdates = 0;

        foreach ($attributes as $attribute)
       {
            if (isset($attribute['id']))
            {
                $model = $this->findById($attribute['id']);

                if (!is_null($model))
                {
                    if ($model->update(['label' => $attribute['label']]))
                    {
                        $totalSuccessfulUpdates++;
                    }
                }
            }
        }

        return count($attributes) === $totalSuccessfulUpdates;
    }
}