<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $primaryKey = 'id_restoran';

    protected $fillable = [
        'id_merchant',
        'category_id',
        'gambar',
        'nama_restoran',
        'deskripsi',
        'alamat',
        'hari_operasional',
        'jam_operasional',
        'range_harga',
        'kontak',
        'gmaps_link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_merchant');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'restaurant_id', 'id_restoran');
    }

    public function averageRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'restaurant_id', 'id_restoran');
    }

    public function ratingDistribution(): array
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->reviews()->where('rating', $i)->count();
        }
        return $distribution;
    }
}
