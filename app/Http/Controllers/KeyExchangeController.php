<?php

namespace App\Http\Controllers;

use App\Actions\PrivateKey;
use App\Actions\RSACipher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KeyExchangeController extends Controller
{

    public function generatePrivateKeys(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->private_key_one && $user->private_key_two) {
            return redirect()->back();
        }

        $privateKeyOne = (new PrivateKey())->get();

        do {
            $privateKeyTwo = (new PrivateKey())->get();
        } while ($privateKeyOne == $privateKeyTwo);

        $user->private_key_one = $privateKeyOne;
        $user->private_key_two = $privateKeyTwo;
        $user->save();
        $user->refresh();

        return redirect()->back();
    }

    public function generateSharedKeys(): RedirectResponse
    {
        request()->validate([
            'user' => 'exists:users,id'
        ]);

        $user = User::where('id', request()->input('user'))->first();

        $sharedKeyInstance = new \App\Actions\SharedKey(config('defaults.prime_number'));
        $sharedKeyOne = $sharedKeyInstance->getSharedKey(auth()->user()->private_key_one, $user->public_key_one);
        $sharedKeyTwo = $sharedKeyInstance->getSharedKey(auth()->user()->private_key_two, $user->public_key_two);


        $sharedKey = new \App\Models\SharedKey();
        $sharedKey->owner()->associate(auth()->user());
        $sharedKey->user()->associate($user);
        $sharedKey->shared_key_one =$sharedKeyOne;
        $sharedKey->shared_key_two = $sharedKeyTwo;
        $sharedKey->save();

        return redirect()->back();
    }


    public function generateRsaKeys(): RedirectResponse
    {
        $user = auth()->user();
        if ($user->hasRsaKeys()) {
            return redirect()->back();
        }

        $rsa = new RSACipher();
        $rsa->setPrimes();

        $primeP = $rsa->getPrimeP();
        $primeQ = $rsa->getPrimeQ();
        $privateKey = $rsa->getPrivateKey();
        $publicKey = $rsa->getPublicKey();

        $user->prime_p = $primeP;
        $user->prime_q = $primeQ;
        $user->private_key = $privateKey;
        $user->public_key = $publicKey;
        $user->save();

        return redirect()->back();
    }
}
