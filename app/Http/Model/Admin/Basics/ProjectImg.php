<?php

namespace App\Http\Model\Admin\Basics;

use Illuminate\Database\Eloquent\Model;

class ProjectImg extends Model
{

    protected $table = 'project_img';
    public $timestamps = false;
    protected $guarded = [];

    public function getTotalCount($imgName)
    {
        $model = $this->query();

        !empty($imgName) and $model->where('name','like','%' . $imgName . '%');

        return $model->count();
    }

    public function getList($imgName,$offset,$pageSize)
    {
        $model = $this->query()->orderBy('created_at','desc');

        !empty($imgName) and $model->where('name','like','%' . $imgName . '%');

        return $model->offset($offset)->limit($pageSize)->get();
    }

}
