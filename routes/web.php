<?php

use App\Http\Controllers\ELRPDFController;
use App\Http\Controllers\M202Controller;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\QuickLearnController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [M202Controller::class, 'index']);
Route::resource('m202', M202Controller::class)->only(['index', 'edit', 'create', 'store', 'update', 'destroy']);

Route::get('/quicklearn', [QuickLearnController::class, 'index']);
Route::post('/elearning-import',[QuickLearnController::class,'import'])->name('elearning-import');
Route::post('/elearning-trash',[QuickLearnController::class,'trash'])->name('elearning-trash');

Route::resource('peserta', PesertaController::class)->only(['index', 'edit', 'create', 'store', 'update', 'destroy']);
Route::post('/peserta-import',[PesertaController::class,'import'])->name('peserta-import');
Route::post('/peserta-multidelete',[PesertaController::class,'multidelete'])->name('peserta-multidelete');

Route::get('/elrpdf', [ELRPDFController::class, 'index']);
Route::post('/elrpdf-import',[ELRPDFController::class,'import'])->name('elrpdf-import');
