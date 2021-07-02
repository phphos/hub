<?php

namespace PHPHos\Laravel\Models;

use PHPHos\Laravel\Casts\Email;
use PHPHos\Laravel\Casts\Phone;
use PHPHos\Laravel\Models\Model;

class Demo extends Model
{
    /**
     * 业务区分.
     */
    const DOMAIN = 'DEMO';

    /**
     * @var string 表名.
     */
    protected $table = 'demo';
    /**
     * @var array 数组内的列转换为日期格式.
     */
    protected $dates = ['birthday'];
    /**
     * @var array 强制转换的属性.
     */
    protected $casts = [
        'email' => Email::class,
        'phone' => Phone::class,
    ];
}
