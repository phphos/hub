<?php

namespace PHPHos\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPHos\Laravel\Exceptions\Exception;
use PHPHos\Laravel\Http\Requests\SearchPost;
use PHPHos\Laravel\Services\CurdService;

abstract class CurdController extends Controller
{
    /**
     * @var CurdService 服务.
     */
    protected CurdService $service;
    /**
     * @var array 设置验证规则.
     */
    protected $setRules;
    /**
     * @var array 搜索验证规则.
     */
    protected $searchRules;
    /**
     * @var array 字段.
     */
    protected $columns = ['*'];

    public function __construct()
    {
        $this->searchRules = SearchPost::rules();
    }

    public function add(Request $request)
    {
        $input = $this->validated($request, $this->setRules);

        return $this->service->add($input);
    }

    public function get(Request $request)
    {
        $input = $request->validate(['id' => 'required|string']);

        return $this->service->get($input['id'], $this->columns);
    }

    public function set(Request $request)
    {
        $input1 = $request->validate(['id' => 'required|string']);
        $input2 = $this->validated($request, $this->setRules);
        $input = array_merge($input1, $input2);

        $model = $this->service->get($input['id']);
        $model or Exception::fail('参数ID无效.');

        $ok = $this->service->set($model, $input);
        $ok or Exception::fail(Exception::FAIL);
    }

    public function del(Request $request)
    {
        $input = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'string|distinct',
        ]);

        $ok = $this->service->del($input['ids']);
        $ok or Exception::fail(Exception::FAIL);
    }

    public function search(Request $request)
    {
        $input = $this->validated($request, $this->searchRules);

        return $this->service->search($input);
    }

    protected function validated(Request $request, array $rules)
    {
        $data = $request->all();

        return Validator::make($data, $rules)->validated();
    }
}
