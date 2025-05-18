<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        // 'barcode',
        'price',
        'tax',
        // 'quantity',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Returns the URL of the product's image.
     *
     * If the product has no image, a placeholder image is returned.
     *
     * @return string
     */
    public function getImageUrl(): string
    {
        $url = '';

        if ($this->image) {
            $url = Storage::url($this->image);
        }

        dd($url);

        return $url ?: asset('images/placeholder.jpg');
    }
}
