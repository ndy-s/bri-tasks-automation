<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportPeserta implements WithMultipleSheets {

    protected $bulan;

    function __construct($bulan) {
        $this->bulan = $bulan;
    }

    public function sheets(): array {
        return [
            0 => new ImportPesertaSheet($this->bulan),
        ];
    }
}
