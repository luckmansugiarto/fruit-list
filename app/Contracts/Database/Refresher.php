<?php

namespace App\Contracts\Database;

interface Refresher
{
    /**
     * refresh corresponding database entries based on the given source
     *
     * @param  string|null  $sourceLocation
     * @return boolean
     */
    public function refreshData($eloquentRepository, $sourceLocation);
}