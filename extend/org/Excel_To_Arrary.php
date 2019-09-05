<?php

namespace org;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Excel5;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Cell;


class Excel_To_Arrary {
    public function __construct() {
        //Vendor("Excel.PHPExcel");//引入phpexcel类(注意你自己的路径)
        //Vendor("Excel.PHPExcel.IOFactory");
    }

    /**
     * 读取Excel 并返回数组
     * Author: websky
     * @param $filename excel文件路径
     * @param $encode 编码
     * @param $file_type xls/xlsx
     * @return array
     */
    public function read($filename,$encode,$file_type){
        if(strtolower ( $file_type )=='xls')//判断excel表类型为2003还是2007
        {
            //Vendor("Excel.PHPExcel.Reader.Excel5");
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
        }elseif(strtolower ( $file_type )=='xlsx'){
            //Vendor("Excel.PHPExcel.Reader.Excel2007");
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        }
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
        }
        return $excelData;
    }

    /**
     * 返回excel数组
     * Author: websky
     * @param $filename excel文件路径
     * @param $file_type xls/xlsx
     * @return array
     */
    public static function getArray($filename,$file_type='xls'){
        $phpecel = new Excel_To_Arrary();
        return $phpecel->read($filename,false,$file_type);
    }

}
