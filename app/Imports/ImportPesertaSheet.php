<?php

namespace App\Imports;

use App\Models\Peserta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPesertaSheet implements ToCollection, WithHeadingRow {
    /**
    * @param Collection $collection
    */

    protected $bulan;

    function __construct($bulan) {
        $this->bulan = $bulan;
    }

    public function collection(Collection $collection) {
        foreach ($collection as $coll) {
            Peserta::create([
                'bulan' => $this->bulan,
                'bulanabrv' => $this->monthList($this->bulan),
                'pn' => $coll['pn'],
                'name' => $coll['nama'],
                'uker' => $coll['uker'],
                'keterangan' => $coll['keterangan'] ?? null,
                'status' => $coll['status'] ?? null,
            ]);
        }
    }

    public function headingRow(): int {
        return 4;
    }

    public function monthList($month) {
        if ($month == 'Januari') {
            return 1;
        } else if ($month == 'Februari') {
            return 2;
        } else if ($month == 'Maret') {
            return 3;
        } else if ($month == 'April') {
            return 4;
        } else if ($month == 'Mei') {
            return 5;
        } else if ($month == 'Juni') {
            return 6;
        } else if ($month == 'Juli') {
            return 7;
        } else if ($month == 'Agustus') {
            return 8;
        } else if ($month == 'September') {
            return 9;
        } else if ($month == 'Oktober') {
            return 10;
        } else if ($month == 'November') {
            return 11;
        } else if ($month == 'Desember') {
            return 12;
        } else {
            return 0;
        }
    }
}
