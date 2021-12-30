<?php

namespace App\Http\Model\Admin\Stock;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $table = 'stock';
    public $timestamps = false;
    protected $guarded = [];

    public function getTotalCount($company,$goodsName)
    {
        $model = $this->query()->leftJoin('goods','stock.goods_id','goods.id');

        !empty($goodsName) and $model->where('goods.name','like','%' . $goodsName . '%');
        !empty($company) and $model->where('goods.company','like','%' . $company . '%');

        return $model->count();
    }

    public function getList($company,$goodsName,$offset,$pageSize)
    {
        $model = $this->query()->orderBy('stock.created_at','desc')->leftJoin('goods','stock.goods_id','goods.id');
        $model->select('stock.id','stock.goods_id','goods.company','goods.name as goods_name','goods.specification as goods_specification','goods.unit as goods_unit','stock.count','stock.updated_at','stock.created_at');

        !empty($goodsName) and $model->where('goods.name','like','%' . $goodsName . '%');
        !empty($company) and $model->where('goods.company','like','%' . $company . '%');

        return $model->offset($offset)->limit($pageSize)->get();
    }

}
