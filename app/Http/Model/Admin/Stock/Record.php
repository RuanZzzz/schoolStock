<?php

namespace App\Http\Model\Admin\Stock;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'record';
    public $timestamps = false;
    protected $guarded = [];

    public function getTotalCount($goodsName,$recordName,$operaType,$time)
    {
        $model = $this->query()->leftJoin('goods','record.goods_id','goods.id');

        !empty($goodsName) and $model->where('goods.name','like','%' . $goodsName . '%');
        !empty($recordName) and $model->where('record_name','like','%' . $recordName . '%');
        !empty($operaType) and $model->where('opera_type',$operaType);
        !empty($time) and $model->where('created_at',$time);

        return $model->count();
    }

    public function getList($goodsName,$recordName,$operaType,$time,$offset,$pageSize)
    {
        $model = $this->query()->orderBy('record.created_at','desc')->leftJoin('goods','record.goods_id','goods.id');
        $model->select('record.id','record.goods_id','goods.company','goods.name as goods_name','goods.specification as goods_specification',
                               'goods.unit as goods_unit','record.record_time','record.record_name','record.goods_price','record.goods_total_price','goods.cate as goods_cate','record.opera_type','record.remark');

        !empty($goodsName) and $model->where('goods.name','like','%' . $goodsName . '%');
        !empty($recordName) and $model->where('record_name','like','%' . $recordName . '%');
        !empty($operaType) and $model->where('opera_type',$operaType);
        !empty($time) and $model->where('created_at',$time);

        return $model->offset($offset)->limit($pageSize)->get();
    }

    public function exportList($goodsName,$recordName,$operaType,$time)
    {
        $model = $this->query()->orderBy('created_at','desc');

        !empty($goodsName) and $model->where('goods_name','like','%' . $goodsName . '%');
        !empty($recordName) and $model->where('record_name','like','%' . $recordName . '%');
        !empty($operaType) and $model->where('opera_type',$operaType);
        !empty($time) and $model->where('created_at','like',$time . '%');

        return $model->get();
    }

}
