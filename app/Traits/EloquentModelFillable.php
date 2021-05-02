<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

/**
 * Reusable code that can be use to grab all table columns.
 *
 * @since 1.0
 *
 * @version 1.0.0
 */
trait EloquentModelFillable
{
    /**
     * Auto-resolve fillable columns.
     *
     * @return array The fillable.
     */
    public function getFillable()
    {
        return Schema::getColumnListing($this->getTable());
    }
}
