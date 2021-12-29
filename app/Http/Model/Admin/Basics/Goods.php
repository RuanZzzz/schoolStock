<?php

namespace App\Http\Model\Admin\Basics;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{

    protected $table = 'goods';
    public $timestamps = false;
    protected $guarded = [];

    public function getTotalCount($goodsName)
    {
        $model = $this->query();

        !empty($goodsName) and $model->where('name','like','%' . $goodsName . '%');

        return $model->count();
    }

    public function getList($goodsName,$offset,$pageSize)
    {
        $model = $this->query()->orderBy('created_at','desc');

        !empty($goodsName) and $model->where('name','like','%' . $goodsName . '%');

        return $model->offset($offset)->limit($pageSize)->get();
    }

}
