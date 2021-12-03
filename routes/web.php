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
    Route::post('obtain-private-key', [KeyExchangeController::class, 'generatePrivateKeys'])->name('generate-private-keys');
    Route::post('obtain-shared-key', [KeyExchangeController::class, 'generateSharedKeys'])->name('generate-shared-keys');
    Route::post('obtain-rsa-keys', [KeyExchangeController::class, 'generateRsaKeys'])->name('generate-rsa-keys');

    Route::get('/affine/{user?}', [MessageController::class, 'affineShow'])->name('message.affine.show');
    Route::post('/affine/{user}', [MessageController::class, 'affineStore'])->name('message.affine.store');

    Route::get('/rsa/{user?}', [MessageController::class, 'rsaShow'])->name('message.rsa.show');
    Route::post('/rsa/{user}', [MessageController::class, 'rsaStore'])->name('message.rsa.store');

});

