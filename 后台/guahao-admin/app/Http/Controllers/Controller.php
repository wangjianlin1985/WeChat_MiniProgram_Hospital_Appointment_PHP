<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**拼接查询query
     * @param \Illuminate\Http\Request $request
     * @param $model
     * @return $query
     */
    public function getQuery(\Illuminate\Http\Request $request,$model)
    {
        $query = $model::query();//获取到$query
        $searchFields = $model::searchFields;//获取模型的查询条件二维数组
        foreach ($searchFields as $field) {
            if ($field['type'] == '=') {
                $value = $request->get($field['field']);
                if (!is_null($value)) {
                    $query->where($field['field'], $value);
                }
            } elseif ($field['type'] == 'like') {
                $value = $request->get($field['field']);
                if (!is_null($value)) {
                    $query->where($field['field'], 'LIKE', '%' . $value . '%');
                }
            } else {
                $value = $request->get($field['field']);
                if (!is_null($value)) {
                    $query->where($field['field'], $field['type'], $value);
                }
            }
        }
        return $query;
    }

    public function getPaginate(\Illuminate\Http\Request $request,$query)
    {
        $page = $request->get('page',1);//默认第一页
        $limit = $request->get('limit',10);//默认每页10条
        return $query->orderBy('id','desc')->offset(($page-1)*$limit)->limit($limit)->get();
    }

    /**返回layuitable默认规定的数据格式
     * @param \Illuminate\Http\Request $request
     * @param $query
     * @param string $message
     * @return {"code": 0, "msg": "", "count": 1000, "data": [{}, {}]}
     */
    public function outTable(\Illuminate\Http\Request $request,$query, $message = "ok")
    {
        $page = $request->get('page',1);//默认第一页
        $limit = $request->get('limit',10);//默认每页10条
        return [
            'code' => 0,
            'msg' => $message,
            'count' => $query->count(),
            'data' => $query->offset(($page-1)*$limit)->limit($limit)->get(),
        ];
    }

    public function outTableData($data,$count,$message = 'ok'){
        return [
            'code' => 0,
            'msg' => $message,
            'count' => $count,
            'data' => $data,
        ];
    }

    //返回正确的ajax响应
    public function successJson($data)
    {
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ];
    }

    //返回错误的ajax响应
    public function failJson($msg)
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'data' => []
        ];
    }
}
