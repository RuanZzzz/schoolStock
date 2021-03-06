<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Handlers\pagingHandler;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin\Basics\Goods;
use App\Http\Model\Admin\Stock\Record;
use App\Http\Model\Admin\Stock\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{

    /**
     * 库存管理列表
     */
    public function index()
    {
        return view('admin.stock.stock.index');
    }

    /**
     * 获取库存总数
     * @param Request $request
     * @param Stock $stock
     * @param pagingHandler $pagingHandler
     * @return array
     */
    public function getCount(Request $request,Stock $stock,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $goodsName = $request->get('goodsName');
        $company = $request->get('company');

        $total = $stock->getTotalCount($company,$goodsName);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);

        $data = [
            'total' => $total,
            'totalPage' => $totalPages,
            'pageSize' => $pageSize
        ];

        return $data;
    }

    /**
     * 获取库存信息table元素
     * @param Request $request
     * @param Stock $stock
     * @param pagingHandler $pagingHandler
     * @return
     */
    public function getElement(Request $request,Stock $stock,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $page = $request->get('pageNum');
        $goodsName = $request->get('goodsName');
        $company = $request->get('company');

        $total = $stock->getTotalCount($company,$goodsName);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);
        $offset = $pagingHandler->getLimitPage($page,$pageSize,$totalPages);

        $stockList = $stock->getList($company,$goodsName,$offset,$pageSize);

        $data = [
            'stockList' => $stockList
        ];

        return view('admin.stock.stock.stockListElement',$data);
    }

    /**
     * 物品入库页面
     */
    public function addGoods(Request $request)
    {
        $goodsId = $request->get('goodsId');
        $goodsInfo = Goods::query()->find($goodsId);

        $data = [
            'goodsInfo' => $goodsInfo
        ];

        return view('admin.stock.stock.addGoods',$data);
    }

    /**
     * 存储入库物品
     */
    public function storeGoods(Request $request)
    {
        $goodsId = $request->get('goodsId');
        $goodsInfo = Goods::query()->find($goodsId);

        // 数量非空判断
        if (empty($request->get('count'))) {
            return [
                'error' => 500,
                'message' => '请填写数量！'
            ];
        }

        // 入库时间非空判断
        if (empty($request->get('recordTime'))) {
            return [
                'error' => 500,
                'message' => '请填写入库时间！'
            ];
        }

        // 原本库里的数量
        $oldCount = Stock::query()->where('goods_id',$goodsId)->value('count');
        $newCount = $request->get('count') + $oldCount;

        // 更新数量
        $updateStockCount = Stock::query()->where('goods_id',$goodsId)->update([
            'count' => $newCount,
            'updated_at' => nowTime()
        ]);

        if ($updateStockCount) {
            $goodsName = empty($goodsInfo['specification']) ? $goodsInfo['name'] : $goodsInfo['name'] . '(' . $goodsInfo['specification'] .')';
            // 入库成功后，需要记录一下操作记录
            Record::query()->create([
                'goods_id' => $goodsInfo['id'],
                'goods_count' => $request->get('count'),    // 每次入库的数量
                'record_time' => $request->get('recordTime'),
                'created_at' => nowTime(),
                'opera_type' => '入库',
                'record_name' => '谢彩云'
            ]);
        }

        return [
            'error' => 200,
            'message' => '入库成功！'
        ];
    }

    /**
     * 出库回显
     */
    public function checkout(Request $request)
    {
        $checkoutId = $request->get('checkoutId');
        $stockInfo = Stock::query()->find($checkoutId);
        $goodsInfo = Goods::query()->find($stockInfo->goods_id);

        $data = [
            'stockInfo' => $stockInfo,
            'goodsInfo' => $goodsInfo
        ];

        return view('admin.stock.stock.checkout',$data);
    }

    /**
     * 保存出库内容
     */
    public function storeOutStock(Request $request)
    {
        $stockId = $request->get('stockId');
        $outCount = (int)$request->get('goods_count');
        $goodsId = $request->get('goodsId');

        if (empty($outCount)) {
            return [
                'error' => 500,
                'message' => '请输入出库的数量'
            ];
        }

        // 出库时间非空判断
        if (empty($request->get('recordTime'))) {
            return [
                'error' => 500,
                'message' => '请填出库时间！'
            ];
        }

        if (!is_int($outCount)) {
            return [
                'error' => 500,
                'message' => '出库数量必须是整数'
            ];
        }

        if (empty($request->get('record_name'))) {
            return [
                'error' => 500,
                'message' => '请填写取件人名称'
            ];
        }

        $stockInfo = Stock::query()->find($stockId);
        if ($outCount > $stockInfo['count']) {
            return [
                'error' => 500,
                'message' => '出库数量不能大于现有数量'
            ];
        }

        $goodsInfo = Goods::query()->find($goodsId);
        $newCount = $stockInfo['count'] - $outCount;
        // 先更新数量
        $updateStock = Stock::query()->where('id',$stockId)->update([
            'count' => $newCount
        ]);

        if ($updateStock) {
            // 出库记录存储
            Record::query()->create([
                'goods_id' => $goodsInfo['id'],
                'goods_count' => $outCount,    // 每次出库的数量
                'goods_price' => $goodsInfo['price'],
                'goods_total_price' => $outCount * $goodsInfo['price'],
                'record_time' => $request->get('recordTime'),
                'created_at' => nowTime(),
                'opera_type' => '出库',
                'record_name' => $request->get('record_name'),
                'remark' => $request->get('remark')
            ]);

        }

        return [
            'error' => 200,
            'message' => '出库成功！'
        ];
    }

}
