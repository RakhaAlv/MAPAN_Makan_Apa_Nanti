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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class, 'id_merchant');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper: cek apakah user punya restoran (bisa jadi merchant)
    public function hasRestaurant(): bool
    {
        return $this->restaurant()->exists();
    }

    // Helper: cek apakah user adalah user biasa
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
