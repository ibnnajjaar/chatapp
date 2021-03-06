<?php

namespace App\Models;

use App\Actions\AffineCipher;
use App\Actions\PublicKey;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sharedKeys(): HasMany
    {
        return $this->hasMany(SharedKey::class, 'owner_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function saveSharedKey(User $user, int $shared_key)
    {
        $sharedKey = new SharedKey();
        $sharedKey->user()->associate($user);
        $sharedKey->shared_key = $shared_key;
        $this->sharedKeys()->save($sharedKey);
    }

    public function hasRsaKeys(): bool
    {
        return $this->prime_p && $this->prime_q && $this->public_key && $this->private_key;
    }

    public function getPublicKeyOneAttribute(): int
    {
        if (! $this->private_key_one) {
            return 0;
        }

        return (new PublicKey(
            config('defaults.prime_number'),
            config('defaults.generator_number'),
            $this->private_key_one
        ))->calculate();
    }

    public function getPublicKeyTwoAttribute(): int
    {
        if (! $this->private_key_two) {
            return 0;
        }

        return (new PublicKey(
            config('defaults.prime_number'),
            config('defaults.generator_number'),
            $this->private_key_two
        ))->calculate();
    }

    public function getPublicNAttribute()
    {
        return $this->prime_p * $this->prime_q;
    }

    public function sharedKeyOneWith(User $user)
    {
        $shared_key = $this->sharedKeys()->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        return $shared_key->shared_key_one ?? 0;
    }

    public function sharedKeyTwoWith(User $user)
    {
        $shared_key = $this->sharedKeys()->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        return $shared_key->shared_key_two ?? 0;
    }

    public function affineCipherKeyOne(User $user): float
    {
        $shared_private_key_one = $this->sharedKeyOneWith($user);
        $modded_key = fmod($shared_private_key_one, 27);
        return AffineCipher::getKeyOneFor($modded_key);
    }

    public function affineCipherKeyTwo(User $user): float
    {
        $shared_private_key_two = $this->sharedKeyTwoWith($user);
        return fmod($shared_private_key_two, 27);
    }

    public function hasExchangeKeys(): bool
    {
        return $this->private_key_one && $this->private_key_two;
    }

    public function hasSharedKeyFor(User $user): bool
    {
        return $this->sharedKeyOneWith($user) && $this->sharedKeyTwoWith($user);
    }
}
