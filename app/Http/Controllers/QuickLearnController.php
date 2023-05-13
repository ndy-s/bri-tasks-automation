<?php

namespace App\Http\Controllers;

use App\Exports\ExportM202;
use App\Imports\ImportQuickLearn;
use App\Models\ELearning;
use App\Models\M202;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class QuickLearnController extends Controller {
    public function index() {
        $Elearning = ELearning::query()->count();

        return view('quicklearn', [
            'title' => 'Quick E-Learning',
            'Elearning' => $Elearning,
        ]);
    }

    public function import(Request $request) {
        try {
            $files = $request->file('file');
            $zipName = 'processed_e-learning_files.zip';
            $zipPath = storage_path('app/' . $zipName);
            $zip = new ZipArchive();
            $zip->open($zipPath, ZipArchive::CREATE);

            if($request->hasFile('file')) {
                foreach ($files as $file) {
                    $allowedfileExtension = ['xlsx', 'xls'];
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension,$allowedfileExtension);

                    if($check) {
                        $fileName = strtolower($file->getClientOriginalName());
                        if (preg_match('(penegasan|penamaan)', $fileName) === 1) {
                            $M202 = M202::query()->where('code', 'M202301940')->pluck('id');

                            Excel::import(new ImportQuickLearn($M202), $file->store('files'));
                            $excelFile =  Excel::download(new ExportM202($M202), 'M202301940.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                            $excelFileName = 'M202301940.xlsx';

                            Storage::put('zip/'.$excelFileName, file_get_contents($excelFile->getFile()));
                            $zip->addFile(storage_path('app/zip/' . $excelFileName), $excelFileName);
                            Storage::delete($excelFile->getFile());
                        } else if (preg_match('(smart|new|normal|ppkm)', $fileName) === 1) {
                            $M202 = M202::query()->where('code', 'M202301941')->pluck('id');

                            Excel::import(new ImportQuickLearn($M202), $file->store('files'));
                            $excelFile = Excel::download(new ExportM202($M202), 'M202301941.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                            $excelFileName = 'M202301941.xlsx';

                            Storage::put('zip/'.$excelFileName, file_get_contents($excelFile->getFile()));
                            $zip->addFile(storage_path('app/zip/' . $excelFileName), $excelFileName);
                            Storage::delete($excelFile->getFile());
                        } else if (preg_match('(penggunaan|ist)', $fileName) === 1) {
                            $M202 = M202::query()->where('code', 'M202301943')->pluck('id');

                            Excel::import(new ImportQuickLearn($M202), $file->store('files'));
                            $excelFile = Excel::download(new ExportM202($M202), 'M202301943.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                            $excelFileName = 'M202301943.xlsx';

                            Storage::put('zip/'.$excelFileName, file_get_contents($excelFile->getFile()));
                            $zip->addFile(storage_path('app/zip/' . $excelFileName), $excelFileName);
                            Storage::delete($excelFile->getFile());
                        } else if (preg_match('(operasional|layanan)', $fileName) === 1) {
                            $M202 = M202::query()->where('code', 'M202301944')->pluck('id');

                            Excel::import(new ImportQuickLearn($M202), $file->store('files'));
                            $excelFile = Excel::download(new ExportM202($M202), 'M202301944.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                            $excelFileName = 'M202301944.xlsx';

                            Storage::put('zip/'.$excelFileName, file_get_contents($excelFile->getFile()));
                            $zip->addFile(storage_path('app/zip/' . $excelFileName), $excelFileName);
                            Storage::delete($excelFile->getFile());
                        } else if (preg_match('(sop|simpanan)', $fileName) === 1) {
                            $M202 = M202::query()->where('code', 'M202301945')->pluck('id');

                            Excel::import(new ImportQuickLearn($M202), $file->store('files'));
                            $excelFile = Excel::download(new ExportM202($M202), 'M202301945.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                            $excelFileName = 'M202301945.xlsx';

                            Storage::put('zip/'.$excelFileName, file_get_contents($excelFile->getFile()));
                            $zip->addFile(storage_path('app/zip/' . $excelFileName), $excelFileName);
                            Storage::delete($excelFile->getFile());
                        }
                    } else {
                        return response()->json(['error' => 'Invalid file extension. Only xlsx and xls files are allowed.'], 422);
                    }
                }
            }
            $zip->close();
            Storage::deleteDirectory('/zip/', true);
            Storage::deleteDirectory('/files/', true);

            return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error importing files: ' . $e->getMessage()], 500);
        }
    }

    public function trash() {
        ELearning::query()->delete();
        return redirect()->back();
    }
}
