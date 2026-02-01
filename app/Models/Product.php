<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'description',
        'price',
        'stock',
    ];

      // accessor URL gambar
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(storage_path('app/public/products/' . $this->image))) {
            return asset('storage/products/' . $this->image);
        }

        return asset('images/no-image.png');
    }
}
