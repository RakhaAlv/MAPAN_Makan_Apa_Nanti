<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'nama_pengguna',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relasi: user (merchant) punya satu restoran
    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }

    // Relasi: user bisa punya banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper: cek apakah user adalah merchant
    public function isMerchant(): bool
    {
        return $this->role === 'merchant';
    }

    // Helper: cek apakah user adalah user biasa
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
