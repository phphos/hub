<?php

namespace PHPHos\Laravel\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPHos\Laravel\Interfaces\Constant;
use PHPHos\Laravel\Models\Builder;
use PHPHos\Laravel\Models\SoftDeleteModel;
use PHPHos\Laravel\Models\SoftDeletes;
use PHPHos\Laravel\Scopes\ModelScope;
use Ramsey\Uuid\Uuid;

abstract class Model extends SoftDeleteModel implements Constant
{
    use SoftDeletes;

    /**
     * 业务区分.
     */
    const DOMAIN = '';

    /**
     * 记录创建时间.
     */
    const CREATED_AT = 'created_at';
    /**
     * 记录更新时间.
     */
    const UPDATED_AT = 'updated_at';
    /**
     * 软删除字段.
     */
    const DELETED_AT = 'status';

    /**
     * @var bool 自动维护时间戳.
     */
    public $timestamps = true;
    /**
     * @var bool 标识 ID 是否自增.
     */
    public $incrementing = false;

    /**
     * @var string 日期列的存储格式.
     */
    protected $dateFormat = self::DATETIME_FORMAT;
    /**
     * @var string 与表关联的主键.
     */
    protected $primaryKey = 'id';
    /**
     * @var array 不可批量赋值的属性.
     */
    protected $guarded = [];
    /**
     * @var array 模型的默认属性值.
     */
    protected $attributes = [
        'status' => 1,
        'sort' => 0,
        'created_by' => Uuid::NIL,
        'updated_by' => Uuid::NIL,
        'tenant_id' => Uuid::NIL,
    ];
    /**
     * @var array 数组中的属性会被隐藏.
     */
    protected $hidden = [
        'domain',
        'created_by',
        'updated_by',
        'tenant_id',
    ];

    /**
     * 得到表名.
     *
     * @return string
     */
    public static function tableName(): string
    {
        return (new static())->getTable();
    }

    /**
     * 批量添加.
     *
     * @param array $rows 数据.
     * @return bool
     */
    public function addAll(array $rows): bool
    {
        $userid = Auth::id() ?? Uuid::NIL;
        $time = date(static::DATETIME_FORMAT);

        foreach ($rows as &$row) {
            if (!$this->incrementing && !isset($row['id'])) {
                $row['id'] = Str::uuid();
            }
            $row['domain'] = static::DOMAIN;
            $row['created_by'] = $userid;
            $row['created_at'] = $time;
            $row['updated_by'] = $userid;
            $row['updated_at'] = $time;
            $row['tenant_id'] = Uuid::NIL;
        }

        return DB::table($this->getTable())->insert($rows);
    }

    /**
     * 业务区分.
     *
     * @return string
     */
    public function getDomain(): string
    {
        return static::DOMAIN;
    }

    /**
     * @inheritdoc
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ModelScope);

        $userid = Auth::id() ?? Uuid::NIL;
        static::creating(function ($model) use ($userid) {
            if (!$model->incrementing && !$model->id) {
                $model->id = Str::uuid();
            }
            $model->domain = $model::DOMAIN;
            $model->created_by = $userid;
            $model->updated_by = $userid;
            $model->tenant_id = Uuid::NIL;
        });

        $callback = function ($model) use ($userid) {
            $model->updated_by = $userid;
        };

        static::saving($callback);
        static::updating($callback);
        static::deleting($callback);
    }

    /**
     * @inheritdoc
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        $value = $date->format($this->dateFormat);

        return $value == static::DATETIME_NIL ? '' : $value;
    }
}
