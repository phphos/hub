<?php

namespace PHPHos\Laravel\Interfaces;

interface Constant
{
    /**
     * 日期: 日期时间格式.
     */
    const DATETIME_FORMAT = 'Y-m-d H:i:s';
    /**
     * 日期: 日期格式.
     */
    const DATE_FORMAT = 'Y-m-d';
    /**
     * 日期: 日期时间.
     */
    const DATETIME_NIL = '1970-01-01 00:00:00';
    /**
     * 日期: 日期.
     */
    const DATE_NIL = '1970-01-01';
    /**
     * 日期: 时间.
     */
    const TIME_NIL = '00:00:00';

    /**
     * 状态: 关闭.
     */
    const STATUS_OFF = 0;
    /**
     * 状态: 开启.
     */
    const STATUS_ON = 1;
    /**
     * 状态: 全部.
     */
    const STATUS_ALL = [
        self::STATUS_OFF,
        self::STATUS_ON,
    ];

    /**
     * 排序: 正序.
     */
    const SORT_ASC = 'asc';
    /**
     * 排序: 倒序.
     */
    const SORT_DESC = 'desc';
    /**
     * 排序: 全部.
     */
    const SORT_ALL = [
        self::SORT_ASC,
        self::SORT_DESC,
    ];

    /**
     * 排序: 字段.
     */
    const SORT_NAME = 'sorter';

    /**
     * 分页: 页数字段.
     */
    const PAGE_NO_NAME = 'page_no';
    /**
     * 分页: 每页大小字段.
     */
    const PAGE_SIZE_NAME = 'page_size';
}
