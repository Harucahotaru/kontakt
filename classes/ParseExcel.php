<?php

namespace app\classes;


class ParseExcel
{
    public function parse(){
        $a = __DIR__.'\pr.xlsx';
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($a);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cell) {
                var_dump($cell);exit;
                $cell = $cell->getValue(); // Not sure what column this is looping through
                // The $cell->getColumn() method will tell you the column
            }
        }
    }
}