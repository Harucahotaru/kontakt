<?php

namespace app\classes;


use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ParseExcel
{
    public function preview($path, $maxString = 10){
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $rowKey => $row) {
            if ($rowKey> $maxString) {
                break;
            }
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cellKey => $cell) {
                $cell = $cell->getValue();
                $res[$rowKey][$cellKey] = $cell;
            }
        }
        return $res;
    }
}