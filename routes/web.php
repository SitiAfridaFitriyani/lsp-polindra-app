<?php

use App\Http\Controllers\{
    BerkasPemohonController,
    ElemenController,
    EventController,
    JurusanController,
    KelasController,
    KriteriaUnjukKerjaController,
    ProfileController,
    SkemaController,
    TestPraktekController,
    TestTulisController,
    UnitKompetensiController
};
use Illuminate\Support\Facades\Route;

// Root
Route::get('/',fn() => to_route('dashboard'));
Route::view('/dashboard','dashboard.index')->name('dashboard');
// Perangkat Assesmen
Route::resource('event',EventController::class);
Route::get('datatable-event', [EventController::class, 'datatable'])->name('event.datatable');
Route::get('event-skema-list/{uuid}',[EventController::class,'list_skema'])->name('event.list-skema');

Route::resource('skema',SkemaController::class);
Route::get('datatable-skema', [SkemaController::class, 'datatable'])->name('skema.datatable');
Route::get('skema-unitKompetensi-list/{uuid}',[SkemaController::class,'list_unitKompetensi'])->name('skema.list-unitKompetensi');

Route::resource('unit-kompetensi',UnitKompetensiController::class)->names('unitKompetensi');
Route::resource('elemen',ElemenController::class);
Route::resource('kriteria-unjuk-kerja',KriteriaUnjukKerjaController::class)->names('kriteriaUnjukKerja');
Route::resource('berkas-permohonan',BerkasPemohonController::class)->names('berkasPermohonan');
Route::resource('ujian-tulis',TestTulisController::class)->names('ujianTulis');
Route::resource('ujian-praktek',TestPraktekController::class)->names('ujianPraktek');
// Instrumen Pendukung
Route::resource('jurusan',JurusanController::class);
Route::resource('kelas',KelasController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
