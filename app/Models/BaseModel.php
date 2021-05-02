<?php

namespace App\Models;

use App\Traits\EloquentModelFillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use HasFactory, EloquentModelFillable, SoftDeletes;
}