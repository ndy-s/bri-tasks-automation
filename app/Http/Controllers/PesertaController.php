<?php

namespace App\Http\Controllers;

use App\Imports\ImportPeserta;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PesertaController extends Controller {
    public function index(Request $request) {
        if ($request->bulan == null) {
            $peserta = Peserta::all();
        } else {
            $peserta = Peserta::query()->where('bulan', $request->bulan)->get();
        }

        $bulan = Peserta::query()->select('bulan', 'bulanabrv')->orderBy('bulanabrv', 'ASC')->distinct('bulan')->get();

        return view('peserta.index', [
            'title' => 'Daftar Peserta',
            'peserta' => $peserta,
            'bulan' => $bulan
        ]);
    }

    public function import(Request $request) {
        $request->validate([
            'daftarPeserta' => 'required|mimes:xlsx, csv, xls',
            'bulan' => 'required',
        ]);

        $bulan = $request->bulan;
        Excel::import(new ImportPeserta($bulan), $request->file('daftarPeserta')->store('filePeserta'));
        Storage::deleteDirectory('/filePeserta/', true);
        return redirect()->back();
    }

    public function create() {
        return view('peserta.create', [
            'title' => 'Daftar Peserta Create'
        ]);
    }

    public function store(Request $request) {
        $data = $request->all();
        $data['bulanabrv'] = $this->monthList($request->bulan);
        Peserta::create($data);
        return redirect()->route('peserta.index');
    }

    public function edit($id) {
        $peserta = Peserta::findOrFail($id);

        return view('peserta.edit', [
            'title' => 'Daftar Peserta Edit'
        ], compact('peserta'));
    }

    public function update(Request $request, $id) {
        $peserta = Peserta::findOrFail($id);
        $data = $request->all();
        $data['bulanabrv'] = $this->monthList($request->bulan);

        $peserta->update($data);
        return redirect()->route('peserta.index');
    }

    public function destroy($id) {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        return redirect()->route('peserta.index');
    }

    public function multidelete(Request $request) {
        Peserta::query()->where('bulan', $request->bulan)->delete();
        return redirect()->route('peserta.index');
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
