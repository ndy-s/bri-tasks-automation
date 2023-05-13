<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use ZipArchive;

class ELRPDFController extends Controller {

    public function index() {
        $bulan = Peserta::query()->select('bulan', 'bulanabrv')->orderBy('bulanabrv', 'ASC')->distinct('bulan')->get();
        return view('elrpdf', [
            'title' => 'ELR to PDF',
            'bulan' => $bulan,
        ]);
    }

    /**
     * @throws Exception
     */

    public function import(Request $request) {
        try {
            $request->validate([
                'elrpdf' => 'required|mimes:xlsx, csv, xls',
                'bulan' => 'required',
            ]);

            $fileDate = date('d.m.Y',strtotime(str_replace('.xlsx', '', str_replace('elr ', '', strtolower($request->file('elrpdf')->getClientOriginalName())))));
            $spreadsheet = IOFactory::load($request->file('elrpdf'));

            // Get all the sheet names
            $allSheets = $spreadsheet->getSheetNames();
            $colDict = [
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
                'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
                'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
                'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
                'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
                'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
                'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
                'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
            ];

            // Loop through all sheets
            $sheetExport = [];

            foreach ($allSheets as $index => $aSheet) {
                $spreadsheet->setActiveSheetIndexByName($aSheet);
                $sheet = $spreadsheet->getActiveSheet();

                // Your sheet processing code here//
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

                    for ($dx= 14; $sheet->getHighestRow() > $dx; $dx++) {
                        $sheet->getStyle($colDict[0+($i*7)].$dx+1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle($colDict[1+($i*7)].$dx+1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle($colDict[3+($i*7)].$dx+1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        if ($sheet->getCell($colDict[5+($i*7)].$dx+1)->getXfIndex() != null) {
                            $sheet->getStyle($colDict[5+($i*7)].$dx+1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('EF9A9A');
                            $sheet->getStyle($colDict[5+($i*7)].$dx+1)->getFont()->getColor()->setARGB('B71C4A');
                        }
                    }

                }
                $sheet->getPageSetup()->setFitToPage(TRUE);
                $sheet->getPageMargins()->setTop(0.5);
                $sheet->getPageMargins()->setRight(0.1);
                $sheet->getPageMargins()->setLeft(0.1);
                $sheet->getPageMargins()->setBottom(0.5);

                if ($sheet->getCell('B17')->getValue() != null &&
                    $sheet->getCell('I17')->getValue() != null &&
                    $sheet->getCell('P17')->getValue() != null &&
                    $sheet->getCell('W17')->getValue() != null &&
                    $sheet->getCell('AD17')->getValue() != null) {
                    $writer = new Mpdf($spreadsheet);
                    $writer->setSheetIndex($index);

                    $writer->save(storage_path('app/elrpdf/' . $this->abrev($aSheet) . ' '.$fileDate . '.pdf'));

                    $sheetExport[] = $sheet->getTitle();
                } else if ($sheet->getCell('B15')->getValue() != null ||
                    $sheet->getCell('I15')->getValue() != null ||
                    $sheet->getCell('P15')->getValue() != null ||
                    $sheet->getCell('W15')->getValue() != null ||
                    $sheet->getCell('AD15')->getValue() != null) {
                    for ($i=0, $t = 99; $i<5; $i++) {
                        $cellVal = $sheet->getCell($colDict[1+($i*7)].'15')->getValue();
                        $cellVal2 = $sheet->getCell($colDict[1+($i*7)].'16')->getValue();

                        if ($cellVal != null) {
                            $pesertaExist = Peserta::query()->where('bulan', $request->bulan)->where('pn', $cellVal)->count();
                            if ($t > $pesertaExist) {
                                $t = $pesertaExist;
                            }
                        } else if ($cellVal2 != null) {
                            $pesertaExist2 = Peserta::query()->where('bulan', $request->bulan)->where('pn', $cellVal2)->count();
                            if ($t > $pesertaExist2) {
                                $t = $pesertaExist2;
                            }
                        }
                    }

                    if ($t == 0) {
                        $writer = new Mpdf($spreadsheet);
                        $writer->setSheetIndex($index);
                        $writer->save(storage_path('app/elrpdf/' . $this->abrev($aSheet) . ' '.$fileDate . '.pdf'));

                        $sheetExport[] = $sheet->getTitle();
                    }
                }

            }

            // Create a zip file containing all the PDFs
            $zip = new ZipArchive;
            $zipFileName = storage_path('app/elrpdf/processed_final_elr_pdf.zip');
            $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            foreach ($sheetExport as $aSheet) {
                $zip->addFile(storage_path('app/elrpdf/' . $this->abrev($aSheet) . ' '.$fileDate . '.pdf'), $this->abrev($aSheet) . ' '.$fileDate . '.pdf');
            }
            $zip->close();
            foreach ($sheetExport as $aSheet) {
                unlink(storage_path('app/elrpdf/' . $this->abrev($aSheet) . ' '.$fileDate . '.pdf'));
            }
            return response()->download($zipFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error importing files: ' . $e->getMessage()], 500);
        } catch (\DivisionByZeroError $e) {
            return response()->json(['message' => 'Division by zero error: ' . $e->getMessage()], 500);
        }
    }

    function abrev($aSheet) {
        if ($aSheet == 'KC Bagan Siapi api') {
            return 'BAA';
        } else if ($aSheet == 'KC Dumai') {
            return 'DUMAI';
        } else if ($aSheet == 'KC Pekanbaru Sudirman') {
            return 'SDRM';
        } else if ($aSheet == 'KC Selat Panjang') {
            return 'SLPJ';
        } else if ($aSheet == 'KC Tanjung Pinang') {
            return 'TJPN';
        } else if ($aSheet == 'KC Tembilahan') {
            return 'TBLH';
        } else if ($aSheet == 'KC Bengkalis') {
            return 'BKLS';
        } else if ($aSheet == 'KC Bangkinang') {
            return 'BKN';
        } else if ($aSheet == 'KC Rengat') {
            return 'RGT';
        } else if ($aSheet == 'KC Batam Nagoya') {
            return 'BTN';
        } else if ($aSheet == 'KC Duri') {
            return 'DURI';
        } else if ($aSheet == 'KC Tanjung Balai Karimun') {
            return 'TJBLK';
        } else if ($aSheet == 'KC Bagan Batu') {
            return 'BGBT';
        } else if ($aSheet == 'KC Ujung Batu') {
            return 'UJBT';
        } else if ($aSheet == 'KC Batam Center') {
            return 'BTC';
        } else if ($aSheet == 'KC Pangkalan Kerinci') {
            return 'PKLKR';
        } else if ($aSheet == 'KC Perawang') {
            return 'PRW';
        } else if ($aSheet == 'KC Teluk Kuantan') {
            return 'TLK';
        } else if ($aSheet == 'KC Pekanbaru Tuanku Tambusai') {
            return 'TAMB';
        } else if ($aSheet == 'KC Pekanbaru Lancang Kuning') {
            return 'LKN';
        } else if ($aSheet == 'KC Pasir Pengaraian') {
            return 'PASIR';
        } else if ($aSheet == 'KC Siak') {
            return 'SIAK';
        } else {
            return 'No Name';
        }
    }
}
