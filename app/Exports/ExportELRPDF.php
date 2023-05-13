<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOption\None;
use ZipArchive;

class ExportELRPDF implements WithEvents {
    public function registerEvents(): array {
        return [
            BeforeWriting::class  => function(BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile(storage_path('app/elrpdf/CXuoFTVnc1fs2pgvZY5DRpWZ0DHyTDSxzBSttpQi.xlsx'));
                $event->writer->reopen($templateFile, Excel::XLSX);

                $colDict = [
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                    'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK',
                ];

                $allSheets = $event->writer->getSheetNames();

                foreach ($allSheets as $index => $aSheet) {
                    $sheet = $event->writer->getSheetByIndex($index);

                    for ($i=0; $i<5; $i++) {
                        $sheet->mergeCells($colDict[0+($i*7)].'6:'.$colDict[1+($i*7)].'6');
                        $sheet->mergeCells($colDict[2+($i*7)].'6:'.$colDict[5+($i*7)].'6');
                        $sheet->getStyle($colDict[2+($i*7)].'6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $hasil = $sheet->getCell($colDict[3+($i*7)].'10')->getValue() / $sheet->getCell($colDict[3+($i*7)].'8')->getValue();
                        $sheet->setCellValue($colDict[3+($i*7)].'11', $hasil);
                        $sheet->setCellValue($colDict[4+($i*7)].'9', $hasil);

                        if ($hasil > 0.98) {
                            $sheet->getStyle($colDict[4+($i*7)].'9')->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('DCEDC8');

                            $sheet->getStyle($colDict[4+($i*7)].'9')->getFont()->getColor()->setARGB('425E20');
                        } else if ($hasil > 0.9) {
                            $sheet->getStyle($colDict[4+($i*7)].'9')->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFD54F');

                            $sheet->getStyle($colDict[4+($i*7)].'9')->getFont()->getColor()->setARGB('FF9238');
                        } else if ($hasil > -1) {
                            $sheet->getStyle($colDict[4+($i*7)].'9')->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('EF9A9A');

                            $sheet->getStyle($colDict[4+($i*7)].'9')->getFont()->getColor()->setARGB('B71C4A');
                        }

                        $sheet->getStyle($colDict[4+($i*7)].'9')
                            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    }

                    $sheet->getPageSetup()->setFitToPage(TRUE);
                    $sheet->getPageMargins()->setTop(0.5);
                    $sheet->getPageMargins()->setRight(0.1);
                    $sheet->getPageMargins()->setLeft(0.1);
                    $sheet->getPageMargins()->setBottom(0.5);

                    $event->writer->getSheetByIndex($index)->export($event->getConcernable());
                }

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }
}
