<?php

namespace App\Imports;

use App\Exports\ExportM202;
use App\Models\ELearning;
use App\Models\M202;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;

class ImportQuickLearn implements ToCollection, WithHeadingRow {
    /**
    * @param Collection $collection
    */
    protected $M202;

    function __construct($M202) {
        $this->M202 = $M202;
    }

    public function collection(Collection $collection) {
        foreach ($collection as $coll) {
            $M202 = M202::query()->where('id', $this->M202)->select('id')->first();
            if (!empty($coll['werks_tx']) && $coll['werks_tx'] == 'Regional Office Pekanbaru') {
                $M202->elearning()->create([
                    'pn' => $coll['pn'],
                    'name' => $coll['nama_peserta'],
                    'posisi' => $coll['stell_tx'],
                    'area' => $coll['btrtl_tx'],
                    'work_unit' => $coll['uker'],
                    'grade' => $coll['total_nilai'],
                ]);
            } else if (!empty($coll['area']) && $coll['area'] == 'Regional Office Pekanbaru') {
                $M202->elearning()->create([
                    'pn' => $coll['personal_number'],
                    'name' => $coll['participants_name'],
                    'posisi' => $coll['position'],
                    'area' => $coll['subarea'],
                    'work_unit' => $coll['work_unit'],
                    'grade' => $coll['grade'],
                ]);
            }

        }
    }
}
