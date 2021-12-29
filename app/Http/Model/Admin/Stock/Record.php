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
        $model = $this->query();

        !empty($goodsName) and $model->where('goods_name','like','%' . $goodsName . '%');
        !empty($recordName) and $model->where('record_name','like','%' . $recordName . '%');
        !empty($operaType) and $model->where('opera_type',$operaType);
        !empty($time) and $model->where('created_at','like',$time . '%');

        return $model->count();
    }

    public function getList($goodsName,$recordName,$operaType,$time,$offset,$pageSize)
    {
        $model = $this->query()->orderBy('created_at','desc');

        !empty($goodsName) and $model->where('goods_name','like','%' . $goodsName . '%');
        !empty($recordName) and $model->where('record_name','like','%' . $recordName . '%');
        !empty($operaType) and $model->where('opera_type',$operaType);
        !empty($time) and $model->where('created_at','like',$time . '%');

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
