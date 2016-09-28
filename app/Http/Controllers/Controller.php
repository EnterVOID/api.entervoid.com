<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const MAX_PAGE_SIZE = 1500;

    public function paginate(Request $request, $query)
    {
        $page = $request->input('page', 1);
        $pageSize = min($request->input('pageSize', 25), static::MAX_PAGE_SIZE);
        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    /**
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param array $orderData
     */
    protected function order($order, $query) {
        foreach($order as $fieldName => $dir) {
            $dir = $dir ? strtolower($dir) : 'asc';

            if($dir !== 'asc' && $dir !== 'desc') continue;

            $query->orderBy($fieldName, $dir);
        }
    }
}
