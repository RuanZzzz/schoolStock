<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Handlers\excelHandler;
use App\Handlers\pagingHandler;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin\Stock\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{

    public function index()
    {
        $recordTime = Record::query()->select('record_time')->orderBy('record_time','desc')->distinct()->get()->toArray();

        $data = [
            'recordTime' => $recordTime
        ];

        return view('admin.stock.record.index',$data);
    }

    /**
     * 获取操作记录总数
     * @param Request $request
     * @param Record $record
     * @param pagingHandler $pagingHandler
     */
    public function getCount(Request $request,Record $record,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $goodsName = $request->get('goodsName');
        $recordName = $request->get('recordName');
        $operaType = $request->get('type');
        $time = $request->get('time');
        $company = $request->get('company');

        $total = $record->getTotalCount($company,$goodsName,$recordName,$operaType,$time);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);

        $data = [
            'total' => $total,
            'totalPage' => $totalPages,
            'pageSize' => $pageSize
        ];

        return $data;
    }

    /**
     * 获取操作记录table元素
     * @param Request $request
     * @param Record $record
     * @param pagingHandler $pagingHandler
     */
    public function getElement(Request $request,Record $record,pagingHandler $pagingHandler)
    {
        $pageSize = 10;
        $page = $request->get('pageNum');
        $goodsName = $request->get('goodsName');
        $recordName = $request->get('recordName');
        $operaType = $request->get('type');
        $time = $request->get('time');
        $company = $request->get('company');

        $total = $record->getTotalCount($company,$goodsName,$recordName,$operaType,$time);
        $totalPages = $pagingHandler->getTotalPage($pageSize,$total);
        $offset = $pagingHandler->getLimitPage($page,$pageSize,$totalPages);

        $recordList = $record->getList($company,$goodsName,$recordName,$operaType,$time,$offset,$pageSize);

        $data = [
            'recordList' => $recordList
        ];

        return view('admin.stock.record.recordListElement',$data);
    }

    /**
     * 导出报表
     * @param Request $request
     */
    public function exportExcel(Request $request,Record $record,excelHandler $excelHandler)
    {
        $goodsName = $request->get('goodsName');
        $recordName = $request->get('recordName');
        $operaType = $request->get('type');
        $time = $request->get('time');
        $company = $request->get('company');

        $recordList = $record->exportList($company,$goodsName,$recordName,$operaType,$time);

        $exportData = [];
        foreach ($recordList as $k => $val) {
            $exportData[$k]['sort'] = $k + 1;
            $exportData[$k]['company'] = $val['company'];
            $exportData[$k]['goodsName'] = $val['goods_name'];
            $exportData[$k]['goodsCount'] = $val['goods_count'];
            $exportData[$k]['goodsUnit'] = $val['goods_unit'];
            $exportData[$k]['goodsPrice'] = empty($val['goods_price']) ? '' : $val['goods_price'];
            $exportData[$k]['goodsTotalPrice'] = empty($val['goods_total_price']) ? '' : $val['goods_total_price'];
            $exportData[$k]['goodsCate'] = $val['goods_cate'];
            $exportData[$k]['opeType'] = $val['opera_type'];
            $exportData[$k]['time'] = $val['record_time'];
            $exportData[$k]['recordName'] = $val['record_name'];
            $exportData[$k]['remark'] = $val['remark'];
        }

        $head = ['序号','供货商','物品名称','数量','单位','单价','金额','商品类型','动作','时间','签名','备注'];

        $keys = [
            0 => 'sort',
            1 => 'company',
            2 => 'goodsName',
            3 => 'goodsCount',
            4 => 'goodsUnit',
            5 => 'goodsPrice',
            6 => 'goodsTotalPrice',
            7 => 'goodsCate',
            8 => 'opeType',
            9 => 'time',
            10 => 'recordName',
            11 => 'remark'
        ];

        // 文件名
        $fileName = 'stockRecord_' . md5(uniqid(mt_rand(),true)) . ".xlsx";
        // 使用的模板
        $templateDir = public_path() . "/excel/record/template/exportRecord.xlsx";
        $downloadDir = $excelHandler->exportResultByTemplate($templateDir,$fileName,$exportData,$head,$keys,"exportRecord");

        return [
            'error' => 200,
            'message' => "导出成功",
            'downloadUrl' => $downloadDir
        ];
    }

    /**
     * 删除记录
     */
    public function deleteRecord(Request $request)
    {
        $deleteId = $request->get('deleteId');

        $delRecord = Record::query()->find($deleteId)->delete();
        if ($delRecord) {
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

}
