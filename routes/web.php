<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InventarisController as AdminInventarisController;
use App\Http\Controllers\Admin\PerawatanController as AdminPerawatanController;
use App\Http\Controllers\Admin\LaporanKerusakanController as AdminLaporanKerusakanController;
use App\Http\Controllers\Admin\CatatanPerbaikanController;
use App\Http\Controllers\Admin\RekapController as AdminRekapController;
use App\Http\Controllers\Admin\RekapPerawatanController as AdminRekapPerawatanController;


use App\Http\Controllers\Kabid\DashboardController as KabidDashboardController;
use App\Http\Controllers\Kabid\MonitoringKecamatanController;
use App\Http\Controllers\Kabid\MonitoringInventarisController;
use App\Http\Controllers\Kabid\PerawatanController as KabidPerawatanController;
use App\Http\Controllers\Kabid\LaporanKerusakanController as KabidLaporanKerusakanController;
use App\Http\Controllers\Kabid\RekapController as KabidRekapController;
use App\Http\Controllers\Kabid\RekapPerawatanController as KabidRekapPerawatanController;


use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\InventarisController as OperatorInventarisController;
use App\Http\Controllers\Operator\LaporanKerusakanController as OperatorLaporanKerusakanController;
use App\Http\Controllers\Operator\PerawatanController;
use App\Http\Controllers\Operator\RekapController as OperatorRekapController;
use App\Http\Controllers\Operator\RekapPerawatanController as OperatorRekapPerawatanController;

Route::get('/', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');

    Route::resource('kecamatan', KecamatanController::class);

    Route::resource('users', UserController::class);

    Route::resource('inventaris', AdminInventarisController::class);

    Route::get('perawatan', [AdminPerawatanController::class, 'index'])->name('perawatan.index');
    Route::get('perawatan/{id}', [AdminPerawatanController::class, 'show'])->name('perawatan.show');


    Route::get('laporan',[AdminLaporanKerusakanController::class,'index'])->name('laporan.index');
    Route::get('laporan/{id}',[AdminLaporanKerusakanController::class,'show'])->name('laporan.show');
    Route::put('laporan/{id}/diproses',[AdminLaporanKerusakanController::class,'diproses'])->name('laporan.diproses');
    Route::put('laporan/{id}/selesai',[AdminLaporanKerusakanController::class,'selesai'])->name('laporan.selesai');

    Route::post('catatan',[CatatanPerbaikanController::class,'store'])->name('catatan.store');

    Route::get('rekap',[AdminRekapController::class,'index'])->name('rekap.index');
    Route::get('rekap/download',[AdminRekapController::class,'download'])->name('rekap.download');

    Route::get('rekap-perawatan', [AdminRekapPerawatanController::class, 'index'])->name('rekap_perawatan.index');
    Route::get('rekap-perawatan/download', [AdminRekapPerawatanController::class, 'download'])->name('rekap_perawatan.download');

});

Route::middleware(['auth','role:kabid'])->prefix('kabid')->name('kabid.')->group(function () {

    Route::get('/dashboard',[KabidDashboardController::class,'index'])->name('dashboard');

    Route::get('kecamatan',[MonitoringKecamatanController::class,'index'])->name('kecamatan.index');

    Route::get('inventaris',[MonitoringInventarisController::class,'index'])->name('inventaris.index');

    Route::get('perawatan', [KabidPerawatanController::class, 'index'])->name('perawatan.index');
    Route::get('perawatan/{id}', [KabidPerawatanController::class, 'show'])->name('perawatan.show');

    Route::get('laporan',[KabidLaporanKerusakanController::class,'index'])->name('laporan.index');
    Route::get('laporan/{id}',[KabidLaporanKerusakanController::class,'show'])->name('laporan.show');
    Route::put('laporan/{id}/setujui',[KabidLaporanKerusakanController::class,'setujui'])->name('laporan.setujui');
    Route::put('laporan/{id}/tolak',[KabidLaporanKerusakanController::class,'tolak'])->name('laporan.tolak');

    Route::get('rekap',[KabidRekapController::class,'index'])->name('rekap.index');
    Route::get('rekap/download',[KabidRekapController::class,'download'])->name('rekap.download');

    Route::get('rekap-perawatan', [KabidRekapPerawatanController::class, 'index'])->name('rekap_perawatan.index');
    Route::get('rekap-perawatan/download', [KabidRekapPerawatanController::class, 'download'])->name('rekap_perawatan.download');

});

Route::middleware(['auth','role:operator'])->prefix('operator')->name('operator.')->group(function () {

    Route::get('/dashboard',[OperatorDashboardController::class,'index'])->name('dashboard');

    Route::get('inventaris',[OperatorInventarisController::class,'index'])->name('inventaris.index');

    Route::resource('laporan', OperatorLaporanKerusakanController::class);

    Route::resource('perawatan', PerawatanController::class);

    Route::get('rekap',[OperatorRekapController::class,'index'])->name('rekap.index');
    Route::get('rekap/download',[OperatorRekapController::class,'download'])->name('rekap.download');

    Route::get('rekap-perawatan', [OperatorRekapPerawatanController::class, 'index'])->name('rekap_perawatan.index');
    Route::get('rekap-perawatan/download', [OperatorRekapPerawatanController::class, 'download'])->name('rekap_perawatan.download');
});
Route::get('/admin/inventaris/get-latest-kode', [App\Http\Controllers\Admin\InventarisController::class, 'getLatestKode'])->name('admin.inventaris.get-latest-kode');

