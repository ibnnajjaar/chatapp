<?php

namespace App\Http\Controllers;

use App\Actions\PrivateKey;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function show()
    {
        return view('chat');
    }


    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $cleaned = preg_replace('/\PL/u', '', $request->input('message'));
        $cleaned = strtolower($cleaned);




    }

}
