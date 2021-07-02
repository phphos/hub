<?php

namespace PHPHos\Laravel\Http\Requests;

use Illuminate\Validation\Rule;
use PHPHos\Laravel\Models\Model;

abstract class PageRequest extends Request
{
    /**
     * @inheritdoc
     */
    public static function rules()
    {
        return [
            'search' => 'string|max:64',
            'status' => Rule::in(Model::STATUS_ALL),
            static::SORT_NAME => 'array',
            static::SORT_NAME . '.*' => Rule::in(Model::SORT_ALL),
            static::PAGE_NO_NAME => 'integer|min:1',
            static::PAGE_SIZE_NAME => 'integer|min:1|max:100',
        ];
    }
}
