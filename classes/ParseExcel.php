<?php

namespace app\classes;


use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ParseExcel
{
    public const HEADER_NOT_STATE = 'Не задано';

    public const HEADER_NOT_STATE_KEY = 'NOT_STATED';

    public const MAX_PREVIEW_STRINGS = 10;

    /**
     * @param string $path
     * @param int $maxString
     *
     * @return array
     * @throws Exception
     */
    public function preview(string$path, int $maxString = self::MAX_PREVIEW_STRINGS): array
    {
        return self::parseToArray($path, $maxString);
    }

    /**
     * @param string $path
     * @param int|null $maxString
     * @param int|null $offset
     * @return array
     *
     * @throws Exception
     */
    public function parseToArray(string $path, int $maxString = null, int $offset = null): array
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $rowKey => $row) {
            if (!empty($maxString) && $rowKey > $maxString) {
                break;
            }
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cellKey => $cell) {
                $cell = $cell->getValue();
                $res[$rowKey][$cellKey] = $cell;
            }
        }
        if (!empty($offset)) {
            $res = array_slice($res, $offset);
        }

        return $res;
    }

    /**
     * @param array $previewExcel
     *
     * @return array
     */
    public static function getExcelHeaderForCorrelate(array $previewExcel): array
    {
        foreach ($previewExcel[1] as $columnKey => $column) {
            $headers[$columnKey] = "$columnKey";
        }
        $headers[self::HEADER_NOT_STATE_KEY] = self::HEADER_NOT_STATE;

        return array_reverse($headers);
    }
}