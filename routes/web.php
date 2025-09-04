<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\User_Ws;
use App\Http\Controllers\User\Users;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Master\PenyediaController;
use App\Http\Controllers\Master\NarasumberController;
use App\Http\Controllers\Lampiran_Pendukung\LampiranNarasumberController;

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
    });

    Route::middleware(['auth', 'role:super admin|admin'])->group(function () {
        Route::get('/user/login_user_index/{jenis}', [Users::class, 'login_user_index'])->name('users.login_user_index');
        Route::get('/user/users/impersonate/{id}', [Users::class, 'impersonate'])->name('users.impersonate');
    });

    Route::get('/user/users/impersonate', [Users::class, 'impersonate'])->name('users.impersonate.back');

    Route::middleware(['auth', 'role:pembuat spj'])->group(function () {
        Route::resource('master/penyedia', PenyediaController::class);
        Route::resource('master/narasumber', NarasumberController::class);
        Route::resource('lampiran_pendukung/lampiran_narasumber', LampiranNarasumberController::class);
    });

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
