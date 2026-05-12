<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'rating',
        'komentar',
        'gambar',
    ];

    /**
     * Relasi: review ditulis oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: review ditujukan ke satu restoran.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
