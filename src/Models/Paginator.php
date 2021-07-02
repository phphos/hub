<?php

namespace PHPHos\Laravel\Models;

use Illuminate\Pagination\LengthAwarePaginator;
use PHPHos\Laravel\Interfaces\Constant;

class Paginator extends LengthAwarePaginator implements Constant
{
    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            'list' => $this->items->toArray(),
            static::PAGE_NO_NAME => $this->currentPage(),
            static::PAGE_SIZE_NAME => $this->perPage(),
            'total' => $this->total(),
        ];
    }
}
