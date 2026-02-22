<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authenticated users
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Dashboard i User Profile (svi prijavljeni)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/webshop', [ItemController::class, 'index'])->name('webshop');

    // Forma za dodavanje artikla (GET)
    Route::get('/webshop/add', function () {
        if (!Auth::check()) return redirect()->route('login');
        if (!in_array(Auth::user()->role, ['admin', 'foreman'])) abort(403);
        return app(ItemController::class)->create();
    })->name('webshop.add');

    // Spremanje artikla (POST)
    Route::post('/webshop/store', function (\Illuminate\Http\Request $request) {
        if (!Auth::check()) return redirect()->route('login');
        if (!in_array(Auth::user()->role, ['admin', 'foreman'])) abort(403);
        return app(ItemController::class)->store($request);
    })->name('webshop.store');


    /*
    |--------------------------------------------------------------------------
    | Admin only
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin.check')->group(function () {

        // lista korisnika
        Route::get('/users', function () {
            return view('users.users');
        })->name('users');

        // forma za edit korisnika
        // Route::get('/users/edit/{user}', function (\App\Models\User $user) {
        //     return view('users.edit', compact('user'));
        // })->name('users.edit');

        Route::get('/users/edit/{user}', [UserController::class, 'edit'])
            ->name('users.edit');

        // forma za dodavanje korisnika
        Route::get('/users/add', [UserController::class, 'create'])
            ->name('users.add');

        // update korisnika
        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');

        // delete korisnika
        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        // store korisnika
        Route::post('/users/add', [UserController::class, 'store'])
            ->name('users.store');

        // lista poslovnih jedinica
        Route::get('/units', function () {
            return view('units.units');
        })->name('units');
    });
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
