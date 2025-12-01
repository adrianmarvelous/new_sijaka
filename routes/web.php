<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\User_Ws;
use App\Http\Controllers\User\Users;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Master\PenyediaController;
use App\Http\Controllers\Master\NarasumberController;
use App\Http\Controllers\Lampiran_Pendukung\LampiranNarasumberController;
use App\Http\Controllers\Admin\UploadExcel;
use App\Http\Controllers\Admin\ListApi;
use App\Http\Controllers\Admin\SettingOpdController;
use App\Http\Controllers\PrintController;

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // 👥 All authenticated users
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['auth', 'role:super admin'])->group(function () {
        Route::get('/user/user_ws', [User_Ws::class, 'index'])->name('user_ws.index');
        Route::post('/user/user_ws/update_ws', [User_Ws::class, 'update_ws'])->name('user_ws.update_ws');

        // Route::post('/user/user/update_users_db', [Users::class, 'update_users_db'])->name('users.update_users_db');
        Route::get('/user/users', [Users::class, 'index'])->name('users.index');
        Route::post('/user/users/updateorcreate/{opd}', [Users::class, 'updateorcreate'])->name('users.updateorcreate');
        Route::delete('/user/users/delete/{opd}', [Users::class, 'destroy'])->name('users.destroy');
        Route::get('/user/users/assign/{id_user}/{role}', [Users::class, 'assign'])->name('users.assign');        

        Route::get('/test', [TestController::class, 'index'])->name('test.index');
        Route::get('/test/make_users', [TestController::class, 'make_users'])->name('test.make_users');

        Route::get('/upload_excel', [UploadExcel::class, 'index'])->name('upload_excel.index');
        Route::post('/upload_excel/preview', [UploadExcel::class, 'preview'])->name('upload_excel.preview');
        Route::post('/upload_excel/store', [UploadExcel::class, 'store'])->name('upload_excel.store');
        
        Route::resource('list_api', ListApi::class);
    });

    Route::middleware(['auth', 'role:super admin|admin'])->group(function () {
        Route::get('/user/login_user_index/{jenis}', [Users::class, 'login_user_index'])->name('users.login_user_index');
        Route::get('/user/users/impersonate/{id}', [Users::class, 'impersonate'])->name('users.impersonate');
        
        Route::get('/setting_opd', [SettingOpdController::class, 'index'])->name('setting_opd.index');
        Route::post('/store_id_sub', [SettingOpdController::class, 'store_id_sub'])->name('setting_opd.store_id_sub');
        Route::post('/update_id_sub', [SettingOpdController::class, 'update_id_sub'])->name('setting_opd.update_id_sub');
        Route::get('/hapus_id_sub/{id_kegiatan}', [SettingOpdController::class, 'hapus_id_sub'])->name('setting_opd.hapus_id_sub');
    });

    Route::get('/user/users/impersonate', [Users::class, 'impersonate'])->name('users.impersonate.back');

    Route::middleware(['auth', 'role:pembuat spj'])->group(function () {
        Route::resource('master/penyedia', PenyediaController::class);
        Route::resource('master/narasumber', NarasumberController::class);
        Route::resource('lampiran_pendukung/lampiran_narasumber', LampiranNarasumberController::class);
        Route::post('lampiran_pendukung/lampiran_narasumber/tambah_narasumber', [LampiranNarasumberController::class, 'tambah_narasumber'])->name('lampiran_narasumber.tambah_narasumber');
        Route::post('lampiran_pendukung/lampiran_narasumber/update_narasumber', [LampiranNarasumberController::class, 'update_narasumber'])->name('lampiran_narasumber.update_narasumber');
        Route::post('lampiran_pendukung/lampiran_narasumber/hapus_narasumber', [LampiranNarasumberController::class, 'hapus_narasumber'])->name('lampiran_narasumber.hapus_narasumber');
        Route::post('lampiran_pendukung/lampiran_narasumber/hapus_peserta', [LampiranNarasumberController::class, 'hapus_peserta'])->name('lampiran_narasumber.hapus_peserta');
        Route::post('lampiran_pendukung/lampiran_narasumber/tambah_peserta', [LampiranNarasumberController::class, 'tambah_peserta'])->name('lampiran_narasumber.tambah_peserta');

        
        Route::get('narasumber/saran_masukan/{id}', [PrintController::class, 'saran_masukan'])->name('print_narasumber.saran_masukan');
    });

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
