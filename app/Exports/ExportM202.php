<?php

namespace App\Exports;

use App\Models\ELearning;
use App\Models\M202;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportM202 implements WithEvents {
    protected $M202;

    function __construct($M202) {
        $this->M202 = $M202;
    }
    public function registerEvents(): array {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $M202 = M202::query()->where('id', $this->M202)->first();
                $Elearning = ELearning::query()->where('m202_id', $this->M202)->get();
                $sheet = $event->sheet;
                $colDict = [
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
                    'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S',
                    'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                ];

                $sheet->setCellValue('A1', 'LIST OF EXAM PARTICIPANTS');
                $titleStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'name' => 'Verdana'
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_BOTTOM,
                    ],
                ];
                $sheet->getStyle('A1')->applyFromArray($titleStyle);
                $sheet->mergeCells('A1:G1');

                $sheet->setCellValue('A3', 'Exam Information');
                $sheet->getCell('A3')->getStyle()->getFont()->setBold(true);

                $sheet->setCellValue('A4', 'Exam Code');
                $sheet->getCell('A4')->getStyle()->getFont()->setBold(true);
                $sheet->mergeCells('A4:B4');
                $sheet->setCellValue('C4', ': '.$M202->code);
                $sheet->mergeCells('C4:D4');

                $sheet->setCellValue('A5', 'Exam Type');
                $sheet->getCell('A5')->getStyle()->getFont()->setBold(true);
                $sheet->mergeCells('A5:B5');
                $sheet->setCellValue('C5', ': '.$M202->type);
                $sheet->mergeCells('C5:D5');

                $sheet->setCellValue('A6', 'Start Date');
                $sheet->getCell('A6')->getStyle()->getFont()->setBold(true);
                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('C6', ': '.$M202->start_date);
                $sheet->mergeCells('C6:D6');

                $sheet->setCellValue('A7', 'Facilitator');
                $sheet->getCell('A7')->getStyle()->getFont()->setBold(true);
                $sheet->mergeCells('A7:B7');
                $sheet->setCellValue('C7', ': '.$M202->facilitator);
                $sheet->mergeCells('C7:D7');

                $sheet->setCellValue('E4', 'Exam Name');
                $sheet->getCell('E4')->getStyle()->getFont()->setBold(true);
                $sheet->setCellValue('F4', ': '.$M202->name);
                $sheet->mergeCells('F4:G4');

                $sheet->setCellValue('E5', 'Duration');
                $sheet->getCell('E5')->getStyle()->getFont()->setBold(true);
                $sheet->setCellValue('F5', ': '.$M202->duration);
                $sheet->mergeCells('F5:G5');

                $sheet->setCellValue('E6', 'End Date');
                $sheet->getCell('E6')->getStyle()->getFont()->setBold(true);
                $sheet->setCellValue('F6', ': '.$M202->end_date);
                $sheet->mergeCells('F6:G6');

                $sheet->setCellValue('E7', 'Maker');
                $sheet->getCell('E7')->getStyle()->getFont()->setBold(true);
                $sheet->setCellValue('F7', ': '.$M202->maker);
                $sheet->mergeCells('F7:G7');

                $header = ['No', 'PN', 'PARTICIPANT NAME', 'POSISION', 'AREA', 'WORK UNIT', 'GRADE'];

                foreach ($Elearning as $Eindex => $learn) {
                    foreach ($header as $Hindex => $head) {
                        $sheet->setCellValueByColumnAndRow($Hindex+1,9, $head);
                        $sheet->getCellByColumnAndRow($Hindex+1, 9)->getStyle()->getFont()->setBold(true);
                        $sheet->getCellByColumnAndRow($Hindex+1, 9)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    $sheet->setCellValueByColumnAndRow(1,10+$Eindex, $Eindex+1);
                    $sheet->getCellByColumnAndRow(1,10+$Eindex)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValueByColumnAndRow(2,10+$Eindex, $learn->pn);
                    $sheet->getCellByColumnAndRow(2,10+$Eindex)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValueByColumnAndRow(3,10+$Eindex, $learn->name);
                    $sheet->setCellValueByColumnAndRow(4,10+$Eindex, $learn->posisi);
                    $sheet->setCellValueByColumnAndRow(5,10+$Eindex, $learn->area);
                    $sheet->setCellValueByColumnAndRow(6,10+$Eindex, $learn->work_unit);
                    $sheet->setCellValueByColumnAndRow(7,10+$Eindex, $learn->grade);
                    $sheet->getCellByColumnAndRow(7,10+$Eindex)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ];
                $sheet->getStyle('A9:'.$colDict[count($header)-1].count($Elearning)+9)->applyFromArray($borderStyle);

                foreach(range('A','G') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                $sheet->getPageSetup()->setFitToPage(TRUE);
            },
            AfterSheet::class => function (AfterSheet $event) {
                ELearning::query()->where('m202_id', $this->M202)->delete();
            }
        ];
    }
}
