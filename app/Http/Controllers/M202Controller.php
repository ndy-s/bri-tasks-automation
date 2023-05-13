<?php

namespace App\Http\Controllers;

use App\Models\M202;
use DateTime;
use Illuminate\Http\Request;

class M202Controller extends Controller {
    public function index() {
        $M202 = M202::all();

        return view('m202.index', [
            'title' => 'Quick Learning',
            'M202' => $M202,
        ]);
    }

    public function create() {
        return view('m202.create', [
            'title' => 'Quick Learning Create'
        ]);
    }

    public function store(Request $request) {
        $start_date = DateTime::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $end_date = DateTime::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

        $request->merge([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $request->validate([
            'code' => ['required', 'unique:m202_s,code'],
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        M202::create($request->all());
        return redirect()->route('m202.index');
    }

    public function edit(M202 $m202) {
        return view('m202.edit', [
            'title' => 'Quick Learning Edit'
        ], compact('m202'));
    }

    public function update(Request $request, M202 $m202) {
        $start_date = DateTime::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $end_date = DateTime::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

        $request->merge([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $request->validate([
            'code' => ['required', 'unique:m202_s,code,' . $m202->id],
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        $m202->update($request->all());
        return redirect()->route('m202.index');
    }

    public function destroy($id) {
        $M202 = M202::findOrFail($id);
        $M202->delete();
        return redirect()->route('m202.index');
    }
}
