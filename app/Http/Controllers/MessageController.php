<?php

namespace App\Http\Controllers;

use App\Actions\PrivateKey;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function show(?User $user)
    {
        $messages = Message::query()->orderBy('created_at', 'DESC')->with('user')->get();
        return view('chat', [
            'messages' => $messages,
            'user' => $user,
        ]);
    }


    public function store(User $user, Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $cleaned = preg_replace('/\PL/u', '', $request->input('message'));
        $cleaned = strtolower($cleaned);

        $key1 = auth()->user()->affineCipherKeyOne($user);
        $key2 = auth()->user()->affineCipherKeyTwo($user);
        $affineCipher = new \App\Actions\AffineCipher($key1, $key2);
        $cipherText = $affineCipher->encrypt($cleaned);

        $message = new Message();
        $message->message = $cipherText;
        $message->user()->associate(auth()->user());
        $message->save();

        return $this->show($user);
    }

}
