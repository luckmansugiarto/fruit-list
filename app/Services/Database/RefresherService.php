<?php

namespace App\Services\Database;

use App\Contracts\Database\Refresher;
use App\Contracts\DataStructure\ParentReferenceTree;
use Illuminate\Contracts\Container\BindingResolutionException;

class RefresherService implements Refresher
{
    private ParentReferenceTree $treeModel;

    public function __construct(ParentReferenceTree $treeModel)
    {
        $this->treeModel = $treeModel;
    }

    public function refreshData($eloquentRepository, $sourceLocation)
    {
        try
        {
            $repository = app($eloquentRepository);
            $sourceData = json_decode(file_get_contents($sourceLocation), true);
            $sourceData = $this->treeModel->flattenHierarchy($sourceData['menu_items']);
            $repository->bulkSave($sourceData);
        }
        catch (\Illuminate\Contracts\Container\BindingResolutionException $brex)
        {
            echo '[' . date('Y-m-d H:i:s') . ']: ' . $eloquentRepository . ' does not exist';
        }
        catch (\Exception $ex)
        {
            // Other issues
            echo '[' . date('Y-m-d H:i:s') . ']: ' . $ex->getMessage();
        }
    }
}