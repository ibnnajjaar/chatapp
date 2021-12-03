<?php

use App\Actions\PrivateKey;
use App\Actions\SharedKey;
use App\Http\Controllers\KeyExchangeController;
use App\Http\Controllers\MessageController;
use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'users' => User::all()
    ]);
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group([
    'middleware' => 'auth'
], function () {

    // Private Key
    Route::post('/obtain-private-key', [KeyExchangeController::class, 'generatePrivateKeys'])->name('generate-private-keys');

    Route::post('/obtain-shared-key', [KeyExchangeController::class, 'generateSharedKeys'])->name('generate-shared-keys');

    Route::get('/affine', [MessageController::class, 'show'])->name('message.show');
    Route::post('/affine', [MessageController::class, 'store'])->name('message.store');

});
