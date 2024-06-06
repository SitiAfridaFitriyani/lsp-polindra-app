<?php

use App\Http\Controllers\{
    AsesiController,
    AsesorController,
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
Route::middleware('auth')->group(function () {
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
    Route::resource('unit-kompetensi',UnitKompetensiController::class)->names('unitKompetensi')->except(['create', 'show']);
    Route::prefix('unit-kompetensi')->group(function () {
        Route::get('datatable', [UnitKompetensiController::class, 'datatable'])->name('unitKompetensi.datatable');
        Route::get('list',[UnitKompetensiController::class,'list'])->name('unitKompetensi.list');
        Route::get('list/{uuid}', [UnitKompetensiController::class, 'listByUUID'])->name('unitKompetensi.listByUuid');

    });
    // Elemen
    Route::resource('elemen',ElemenController::class)->except(['create', 'show']);
    Route::prefix('elemen')->group(function () {
        Route::get('datatable', [ElemenController::class, 'datatable'])->name('elemen.datatable');
        Route::get('list',[ElemenController::class,'list'])->name('elemen.list');
        Route::get('list/{uuid}', [ElemenController::class, 'listByUUID'])->name('elemen.listByUuid');
    });
    // Kriteria Unjuk Kerja
    Route::resource('kriteria-unjuk-kerja',KriteriaUnjukKerjaController::class)->names('kriteriaUnjukKerja')->except(['create', 'show']);
    Route::prefix('kriteria-unjuk-kerja')->group(function () {
        Route::get('datatable', [KriteriaUnjukKerjaController::class, 'datatable'])->name('kriteriaUnjukKerja.datatable');
        Route::get('list',[KriteriaUnjukKerjaController::class,'list'])->name('kriteriaUnjukKerja.list');
        Route::get('list/{uuid}', [KriteriaUnjukKerjaController::class, 'listByUUID'])->name('kriteriaUnjukKerja.listByUuid');
    });
    // Berkas Permohonan
    Route::resource('berkas-permohonan',BerkasPemohonController::class)->names('berkasPermohonan');
    // Ujian Tulis
    Route::resource('ujian-tulis',TestTulisController::class)->names('ujianTulis');
    Route::prefix('ujian-tulis')->group(function () {
        Route::get('datatable', [TestTulisController::class, 'datatable'])->name('ujianTulis.datatable');
        Route::get('list',[TestTulisController::class,'list'])->name('ujianTulis.list');
        Route::get('list/{uuid}', [TestTulisController::class, 'listByUUID'])->name('ujianTulis.listByUuid');
    });
    // Ujian Praktek
    Route::resource('ujian-praktek',TestPraktekController::class)->names('ujianPraktek');
    // Jurusan
    Route::resource('jurusan',JurusanController::class)->except(['create', 'show']);
    Route::prefix('jurusan')->group(function () {
        Route::get('datatable', [JurusanController::class, 'datatable'])->name('jurusan.datatable');
        Route::get('list',[JurusanController::class,'list'])->name('jurusan.list');
    });
    // Kelas
    Route::resource('kelas',KelasController::class)->except(['create', 'show']);
    Route::prefix('kelas')->group(function () {
        Route::get('datatable', [KelasController::class, 'datatable'])->name('kelas.datatable');
        Route::get('list',[KelasController::class,'list'])->name('kelas.list');
        Route::get('list/{uuid}', [KelasController::class, 'listByUUID'])->name('kelas.listByUuid');
    });
    // Asesor
    Route::resource('asesor',AsesorController::class)->except(['create', 'show']);
    Route::prefix('asesor')->group(function () {
        Route::get('datatable', [AsesorController::class, 'datatable'])->name('asesor.datatable');
        Route::get('list',[AsesorController::class,'list'])->name('asesor.list');
        Route::get('list/{uuid}', [AsesorController::class, 'listByUUID'])->name('asesor.listByUuid');
    });
    // Asesi
    Route::resource('asesi',AsesiController::class)->except(['create', 'show']);
    Route::prefix('asesi')->group(function () {
        Route::get('datatable', [AsesiController::class, 'datatable'])->name('asesi.datatable');
        Route::get('list',[AsesiController::class,'list'])->name('asesi.list');
        Route::get('list/{uuid}', [AsesiController::class, 'listByUUID'])->name('asesi.listByUuid');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
