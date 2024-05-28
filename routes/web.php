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
// Event
Route::resource('event', EventController::class)->except(['create', 'show']);
Route::prefix('event')->group(function () {
    Route::get('datatable', [EventController::class, 'datatable'])->name('event.datatable');
    Route::get('list',[EventController::class,'list'])->name('event.list');
});
// Skema
Route::resource('skema', SkemaController::class)->except(['create', 'show']);
Route::prefix('skema')->group(function () {
    Route::get('datatable', [SkemaController::class, 'datatable'])->name('skema.datatable');
    Route::get('list',[SkemaController::class,'list'])->name('skema.list');
    Route::get('list/{uuid}', [SkemaController::class, 'listByUUID'])->name('skema.listByUuid');
});
// Unit Komptensi
Route::resource('unit-kompetensi',UnitKompetensiController::class)->names('unitKompetensi')->except(['create', 'show']);;
Route::prefix('unit-kompetensi')->group(function () {
    Route::get('datatable', [UnitKompetensiController::class, 'datatable'])->name('unit-kompetensi.datatable');
    Route::get('list',[UnitKompetensiController::class,'list'])->name('unit-kompetensi.list');
    Route::get('list/{uuid}', [UnitKompetensiController::class, 'listByUUID'])->name('unit-kompetensi.listByUuid');

});
// Elemen
Route::resource('elemen',ElemenController::class);
// Kriteria Unjuk Kerja
Route::resource('kriteria-unjuk-kerja',KriteriaUnjukKerjaController::class)->names('kriteriaUnjukKerja');
// Berkas Permohonan
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
