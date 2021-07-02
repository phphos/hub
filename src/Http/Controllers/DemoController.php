<?php

namespace PHPHos\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use PHPHos\Laravel\Http\Controllers\Controller;
use PHPHos\Laravel\Http\Requests\DemoSetPost;
use PHPHos\Laravel\Models\Demo;

class DemoController extends Controller
{
    public function run(DemoSetPost $request)
    {
        $request->validated();

        return Demo::all()->toArray();
    }

    public function add(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $input = $request->only(['name']);

        $model = new Demo();
        $model->fill($input);
        $model->save();
    }

    public function get(Request $request)
    {
        $request->validate(['id' => 'required|string']);
        $input = $request->only(['id']);

        return Demo::findOrFail($input['id'])->toArray();
    }

    public function set(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'name' => 'required|string',
        ]);
        $input = $request->only(['id', 'name']);

        $model = Demo::findOrFail($input['id']);
        $model->fill($input);
        $model->save();
        return $model->toArray();
    }

    public function del(Request $request)
    {
        $request->validate(['id' => 'required|string']);
        $input = $request->only(['id']);

        Demo::destroy($input['id']);
    }

    public function list(Request $request)
    {
        return Demo::select('id', 'name')
            ->get()
            ->toArray();
    }

    public function page(Request $request)
    {
        return Demo::where('status', 1)
            ->orderBy('created_at')
            ->paginate(15, ['id', 'name'], '', 1)
            ->toArray();
    }
}
