<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class IRExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = $this->data;

        // dd($data);
        return view('reports.ir', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set page setup
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);

                // Define merging logic
                $startRow = 2; // Assuming data starts from row 2
                $column = 'A'; // Column to check for merging

                // Group rows by category
                $categories = [];
                foreach ($this->data as $index => $row) {
                    $category = $row['category'];
                    if (!isset($categories[$category])) {
                        $categories[$category] = [];
                    }
                    $categories[$category][] = $startRow + $index;
                }

                // Merge cells for each category
                foreach ($categories as $category => $rows) {
                    if (count($rows) > 1) {
                        $firstRow = min($rows);
                        $lastRow = max($rows);
                        $sheet->mergeCells("$column$firstRow:$column$lastRow");
                    }
                }
            }
        ];
    }
}
