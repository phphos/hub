<?php

namespace PHPHos\Laravel\Services;

use PHPHos\Laravel\Interfaces\Constant;

abstract class Service implements Constant
{
    /**
     * 分页.
     *
     * @param array $data 参数.
     * @param array $columns 字段.
     * @return array
     */
    protected static function page(array $data, array $columns = ['*']): array
    {
        $page = $data[static::PAGE_NO_NAME] ?? 1;
        $size = $data[static::PAGE_SIZE_NAME] ?? 10;

        return [$size, $columns, '', $page];
    }

    /**
     * WHEN.
     *
     * @param mixed $value 值.
     * @param array $where 条件.
     * @return array
     */
    protected static function when($value, array $where): array
    {
        return [
            !static::empty($value),
            static::where($where),
        ];
    }

    /**
     * 条件.
     *
     * @param array $where 条件.
     * @return callable
     */
    protected static function where(array $where): callable
    {
        return function ($query) use ($where) {
            return $query->where(...$where);
        };
    }

    /**
     * 排序.
     *
     * @param array|null $data 参数.
     * @return callable
     */
    protected static function sorter(?array $sorts): callable
    {
        return function ($query) use ($sorts) {
            if ($sorts) {
                foreach ($sorts as $column => $direction) {
                    $query = $query->orderBy($column, $direction);
                }
            }

            return $query;
        };
    }

    /**
     * 空判断.
     *
     * @param mixed $value 值.
     * @return bool
     */
    protected static function empty($value): bool
    {
        return $value === ''
            || $value === []
            || $value === null
            || is_string($value) && trim($value) === '';
    }
}
