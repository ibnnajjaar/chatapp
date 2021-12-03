<?php

use App\Actions\PrivateKey;
use App\Actions\SharedKey;
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
    Route::post('/obtain-private-key', function () {
        (new PrivateKey())->savePrivateKey(auth()->user());

        return redirect()->back();
    })->name('obtain-private-key');


    /**
     * Validate user and
     * obtain shared key then
     * save it in shared keys table
     */
    Route::post('/obtain-shared-key', function (Request $request) {
        request()->validate([
            'user' => 'exists:users,id'
        ]);

        $user = User::where('id', request()->input('user'))->first();

        $sharedKeyInstance = new App\Actions\SharedKey(
            config('defaults.prime_number'),
            auth()->user()->private_key,
            $user->public_key
        );
        $sharedKeyInstance->saveKeyFor(auth()->user(), $user);

        return redirect()->back();
    })->name('obtain-shared-key');

});
