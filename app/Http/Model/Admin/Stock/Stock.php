<?php

namespace App\Http\Model\Admin\Stock;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $table = 'stock';
    public $timestamps = false;
    protected $guarded = [];

    public function getTotalCount($goodsName)
    {
        $model = $this->query();

        !empty($goodsName) and $model->where('goods_name','like','%' . $goodsName . '%');

        return $model->count();
    }

    public function getList($goodsName,$offset,$pageSize)
    {
        $model = $this->query()->orderBy('created_at','desc');

        !empty($goodsName) and $model->where('goods_name','like','%' . $goodsName . '%');

        return $model->offset($offset)->limit($pageSize)->get();
    }

}
