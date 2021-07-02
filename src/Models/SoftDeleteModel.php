<?php

namespace PHPHos\Laravel\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class SoftDeleteModel extends EloquentModel
{
    use SoftDeletes;
}
