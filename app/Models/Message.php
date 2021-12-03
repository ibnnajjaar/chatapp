<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;


    protected $fillable = [
        'message',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function decryptedMessageToUser(User $user = null): string
    {
        if (! $user) {
            return $this->message;
        }

        $key1 = auth()->user()->affineCipherKeyOne($user);
        $key2 = auth()->user()->affineCipherKeyTwo($user);
        $affineCipher = new \App\Actions\AffineCipher($key1, $key2);
        return $affineCipher->decrypt($this->message);
    }
}
