<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const MAX_PAGE_SIZE = 1500;

    /** @var Model */
    protected $model;

    /** @var array */
    protected $orderBy;

    public function get(Request $request, $id)
    {
        $with = $request->input('with');
        if ($with) {
            return response(call_user_func([$this->model, 'with'], $with)->findOrFail($id));
        }
        return response(call_user_func([$this->model, 'findOrFail'], $id));
    }

    public function getMany(Request $request)
    {
        $with = $request->input('with');
        if ($with) {
            $query = call_user_func([$this->model, 'with'], $with);
        } else {
            $query = call_user_func([$this->model, 'query']);
        }
        $order = $request->input('order', $this->orderBy);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function create(Request $request)
    {
        $data = $request->input(snake_case($this->model)) ?? $request->all();
        $model = call_user_func([$this->model, 'create'], $data);

        return $this->save($data, $model);
    }

    public function update(Request $request, $id)
    {
        $data = $request->input(snake_case($this->model)) ?? $request->all();
        $model = call_user_func([$this->model, 'findOrFail'], $id);

        return $this->save($data, $model);
    }

    private function save(array $data, Model $model)
    {
        if (method_exists($model, 'saveWithRelations')) {
            return response($model->saveWithRelations($data));
        }

        $model->fill($data);
        $model->save();
        return response($model->fresh());
    }

    /**
     * @param Request $request
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $query
     * @return mixed
     */
    public function paginate(Request $request, $query)
    {
        $page = $request->input('page', 1);
        $pageSize = min($request->input('pageSize', 25), static::MAX_PAGE_SIZE);
        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    /**
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $query
     * @param array $orderData
     */
    protected function order($order, $query)
    {
        if (empty($order)) {
            return;
        }

        foreach($order as $fieldName => $dir) {
            $dir = $dir ? strtolower($dir) : 'asc';

            if($dir !== 'asc' && $dir !== 'desc') continue;

            $query->orderBy($fieldName, $dir);
        }
    }
}
