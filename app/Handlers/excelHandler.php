<?php

namespace App\Handlers;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class excelHandler
{
    // 格式设置
    const scienceField = ['recordName','time','goodsPrice','goodsTotalPrice'];
    // 宽度设置
    const fieldWidth = ['time','goodsName'];

    public function exportResultByTemplate($templateDir='',$fileName='',$exportData=[],$head=[],$keys=[],$sheetName='')
    {
        ini_set('max_execution_time','0');
        set_time_limit(600);

        // excel存储只制定的文件夹下
        $rootDir = public_path();
        $saveDir = "/excel/record/";
        $this->ensureDir($rootDir . $saveDir);

        // 读取模板文件
        $reader = IOFactory::createReader('Xlsx');

        $spreadsheet = $reader->load($templateDir);
        $worksheet = $spreadsheet->getSheetByName("exportRecord");

        // 表头数量
        $headCnt = count($head);
        // 数据行数
        $rowCnt = count($exportData);

        // 设置样式：加边框
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ];

        // 整个表格样式
        $worksheet->getStyle('A2:' . strtoupper(chr($headCnt + 65 - 1)) . strval($rowCnt + 1))->applyFromArray($styleArray);

        // 根据表头对应的列数，设置样式
        for ($i = 65;$i < $headCnt + 65;$i++) {
            if (in_array($keys[$i - 65],self::fieldWidth)) {
                $worksheet->getColumnDimension(strtoupper(chr($i)))->setWidth(15);
            }

            if ($i == $headCnt + 65 - 1) {
                $worksheet->getColumnDimension(strtoupper(chr($i)))->setWidth(40);
            }
        }

        // 添加内容进模板中
        foreach ($exportData as $key => $item) {
            for ($i = 65;$i < $headCnt + 65;$i++) {
                if (in_array($keys[$i - 65],self::scienceField)) {
                    $worksheet->setCellValueExplicit(strtoupper(chr($i)) . ($key + 2),$item[$keys[$i - 65]],DataType::TYPE_STRING2);
                }else {
                    $worksheet->setCellValue(strtoupper(chr($i)) . ($key + 2),$item[$keys[$i - 65]]);
                }
            }
        }

        $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
        $writer->save($rootDir . $saveDir . $fileName);

        return config('app.url') . $saveDir . "/" . $fileName;
    }

    public function ensureDir($dir)
    {
        is_dir($dir) OR mkdir($dir,0777,true);
    }


}
