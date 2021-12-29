<?php

namespace App\Http\Controllers\Admin\Basics;

use App\Handlers\pagingHandler;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin\Basics\Goods;
use App\Http\Model\Admin\Stock\Stock;
use Illuminate\Http\Request;

class GoodsController extends Controller
{

    /**
     * 物品信息
     */
    public function index()
    {
        return view('admin.basics.goods.index');
    }

    /**
     * 物品数量
     */
    public function getGoodsCount(Request $request,Goods $goods,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $goodsName = $request->get('goodsName');

        $total = $goods->getTotalCount($goodsName);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);

        $data = [
            'total' => $total,
            'totalPage' => $totalPages,
            'pageSize' => $pageSize
        ];

        return $data;
    }

    /**
     * 获取物品信息table元素
     */
    public function getGoodsElement(Request $request,Goods $goods,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $page = $request->get('pageNum');
        $goodsName = $request->get('goodsName');

        $total = $goods->getTotalCount($goodsName);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);
        $offset = $pagingHandler->getLimitPage($page,$pageSize,$totalPages);

        $goodsList = $goods->getList($goodsName,$offset,$pageSize);
        foreach ($goodsList as $k => $val) {
            $goodsList[$k]['name'] = empty($val['specification']) ? $val['name'] : $val['name'] . "(" . $val['specification'] . ")";
        }

        $data = [
            'goodsList' => $goodsList
        ];

        return view('admin.basics.goods.goodsElement',$data);
    }

    public function addGoods()
    {
        return view('admin.basics.goods.addGoods');
    }

    public function storeGoods(Request $request)
    {
        $goodsData['name'] = $request->get('name');
        $goodsData['company'] = $request->get('company');
        $goodsData['specification'] = $request->get('specification');
        $goodsData['unit'] = $request->get('unit');
        $goodsData['cate'] = $request->get('cate');
        $goodsData['price'] = $request->get('price');
        $goodsData['remark'] = $request->get('remark');
        $goodsData['created_at'] = nowTime();

        // 非空判断
        if (empty($goodsData['name'])) {
            return [
                'error' => 500,
                'message' => '请填写物品名称！'
            ];
        }

        if (empty($goodsData['company'])) {
            return [
                'error' => 500,
                'message' => '请填写供货商名称！'
            ];
        }

        if ($goodsData['unit'] === '请选择单位') {
            return [
                'error' => 500,
                'message' => '请选择单位！'
            ];
        }

        if ($goodsData['cate'] === '请选择类别') {
            return [
                'error' => 500,
                'message' => '请选择类别！'
            ];
        }

        if (empty($goodsData['price'])) {
            return [
                'error' => 500,
                'message' => '请填写价格！'
            ];
        }

        // 判断是否有存在的物品
        $existGoods = Goods::query()->where('name',$goodsData['name'])->where('company',$goodsData['company'])->where('specification',$goodsData['specification'])->get()->toArray();
        if ($existGoods) {
            return [
                'error' => 500,
                'message' => '该物品已存在！'
            ];
        }

        $storeResult = Goods::query()->create($goodsData);

        if ($storeResult) {
            // 添加成功并在库存管理中生成对应库存信息
            Stock::query()->create([
                'goods_id' => $storeResult->id,
                'created_at' => nowTime()
            ]);

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
     * 更新物品信息0
     * @param Request $request
     */
    public function editGoods(Request $request)
    {

    }

    /**
     * 删除物品
     */
    public function deleteGoods(Request $request)
    {
        $deleteId = $request->get('deleteId');

        $delGoods = Goods::query()->find($deleteId)->delete();
        $delStock = Stock::query()->where('goods_id',$deleteId)->delete();

        if ($delGoods && $delStock) {
            $data = [
                'error' => 200,
                'message' => '删除成功！'
            ];
        }else {
            $data = [
                'error' => 500,
                'message' => '删除失败！'
            ];
        }

        return $data;
    }

    /**
     * 用于下拉框异步获取物品信息
     */
    public function getList(Request $request,Goods $goods,pagingHandler $pagingHandler)
    {
        $goodsName = $request->get('goodsName');
        $page = $request->get('goodsPage');
        $pageSize = $request->get('goodsPageSize');

        $total = $goods->getTotalCount($goodsName);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);
        $offset = $pagingHandler->getLimitPage($page,$pageSize,$totalPages);

        $goodsList = $goods->getList($goodsName,$offset,$pageSize);
        foreach ($goodsList as $k => $val) {
            $goodsList[$k]['specification'] = !empty($val['specification']) ? $val['specification'] : '';
        }

        $data = [
            'goodsList' => $goodsList,
            'totalGoodsPages' => $totalPages
        ];

        return $data;
    }

}
