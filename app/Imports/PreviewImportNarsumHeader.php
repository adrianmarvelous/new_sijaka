<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PreviewImportNarsumHeader implements ToCollection
{
    public $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection->map(function ($row) {

            // Column B (index 1) → Date
            if (!empty($row[1]) && is_numeric($row[1])) {
                $row[1] = Date::excelToDateTimeObject($row[1])->format('Y-m-d');
            }

            // Column D (index 3) → Time
            if (!empty($row[3]) && is_numeric($row[3])) {
                $row[3] = Date::excelToDateTimeObject($row[3])->format('H:i:s');
            }

            // Column E (index 4) → Time
            if (!empty($row[4]) && is_numeric($row[4])) {
                $row[4] = Date::excelToDateTimeObject($row[4])->format('H:i:s');
            }
            // Column B (index 1) → Date
            if (!empty($row[9]) && is_numeric($row[9])) {
                $row[9] = Date::excelToDateTimeObject($row[9])->format('Y-m-d');
            }


            return $row;
        });
    }
}
