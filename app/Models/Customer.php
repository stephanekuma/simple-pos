<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'avatar',
    ];

    /**
     * Returns the URL of the customer's avatar image.
     *
     * @return string
     */
    public function getAvatarUrl(): string
    {
        return Storage::url(path: $this->avatar);
    }
}
