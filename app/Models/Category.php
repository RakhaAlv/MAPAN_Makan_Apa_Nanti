<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Relasi: kategori punya banyak restoran.
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }
}
