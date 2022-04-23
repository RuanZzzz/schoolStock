<?php

namespace App\Http\Controllers\Admin\Basics;

use App\Handlers\ImageUploadHandler;
use App\Handlers\pagingHandler;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin\Basics\ProjectImg;
use Illuminate\Http\Request;

/**
 * 项目图片控制器：用于存储GitHub项目readme的图片
 */
class ProjectImgController extends Controller
{
    // 项目类别
    const PROJECT2IMG = [
        1 => '并发',
        2 => 'Spring源码',
        3 => 'RuanWiki',
        4 => 'RuanGoBlog'
    ];

    /**
     * 首页
     */
    public function index()
    {
        return view('admin.basics.projectImg.index');
    }

    /*
     * 获取图片分页
     * my_debug(__FILE__,__LINE__,123);
     */
    public function getCount(Request $request,ProjectImg $projectImg,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $keyword = $request->get('keyword');

        $total = $projectImg->getTotalCount($keyword);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);

        return [
            'total' => $total,
            'totalPage' => $totalPages,
            'pageSize' => $pageSize
        ];
    }

    /*
     * 获取图片信息元素
     * my_debug(__FILE__,__LINE__,123);
     */
    public function getElement(Request $request,ProjectImg $projectImg,pagingHandler $pagingHandler)
    {
        $page = $request->get('pageNum');
        $keyword = $request->get('keyword');
        $pageSize = 10;

        $total = $projectImg->getTotalCount($keyword);
        $totalPages= $pagingHandler->getTotalPage($pageSize,$total);
        $offset = $pagingHandler->getLimitPage($page,$pageSize,$totalPages);

        $imgList = $projectImg->getList($keyword,$offset,$pageSize);
        foreach ($imgList as $k => $val) {
            $imgList[$k]['cateName'] = self::PROJECT2IMG[$val['cate_id']];
        }

        $data = [
            'imgList' => $imgList
        ];

        return view('admin.basics.projectImg.imgListElement',$data);
    }

    /**
     * 添加表单
     */
    public function addImg()
    {
        return view('admin.basics.projectImg.addImg');
    }

    /**
     * 存储项目图片信息
     */
    public function storeImg(Request $request)
    {
        $projectImg['name'] = $request->get('name');
        $projectImg['path'] = $request->get('imgPath');
        $projectImg['cate_id'] = $request->get('cateId');
        $projectImg['created_at'] = nowTime();

        $res = ProjectImg::query()->create($projectImg);

        if ($res) {
            $data = [
                'error' => 200,
                'message' => '添加成功！'
            ];
        }else {
            $data = [
                'error' => 500,
                'message' => '添加失败！'
            ];
        }

        return $data;
    }

    /**
     * 图片存储
     */
    public function uploadProjectImg(Request $request, ImageUploadHandler $uploadHandler)
    {
        $imgUpload = $uploadHandler->save($request->upload_file, 'projectImg', guid());
        $imgPath = $imgUpload['path'];

        if ($imgUpload) {
            $data = [
                'error' => 200,
                'imgPath' => $imgPath,
                'message' => '上传成功！'
            ];
        }else {
            $data = [
                'error' => 500,
                'message' => '上传失败！'
            ];
        }

        return $data;
    }

}
