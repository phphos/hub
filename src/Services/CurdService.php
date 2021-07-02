<?php

namespace PHPHos\Laravel\Services;

use PHPHos\Laravel\Models\Model;

abstract class CurdService extends Service
{
    protected $model;

    public function __construct(string $class)
    {
        $this->model = new $class();
    }

    public function add(array $row)
    {
        return $this->set($this->model, $row);
    }

    public function set(Model $model, array $row)
    {
        $model->fill($row);
        $model->save();

        return $model;
    }

    public function get(string $id, array $columns = ['*'])
    {
        return $this->model::find($id, $columns);
    }

    public function del(array $ids)
    {
        return $this->model::destroy($ids);
    }

    public function freeze(array $ids, bool $frozen)
    {
        return $this->model::whereIn('id', $ids)
            ->where('status', $frozen ? Model::STATUS_ON : Model::STATUS_OFF)
            ->update(['status' => $frozen ? Model::STATUS_OFF : Model::STATUS_ON]);
    }

    public function search(array $data = null, array $columns = ['*'])
    {
        isset($data['status']) or $data['status'] = null;
        isset($data[static::SORT_NAME]) or $data[static::SORT_NAME] = null;

        return $this->model::from($this->model->getTable())
            ->when($this->when($data['status'], ['status', $data['status']]))
            ->when(!$this->empty($data[static::SORT_NAME]), $this->sorter($data[static::SORT_NAME]))
            ->orderBy('sort', static::SORT_ASC)
            ->orderBy('created_at', static::SORT_DESC)
            ->paginate(...$this->page($data, $columns))
            ->toArray();
    }
}
