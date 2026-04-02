<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'status',
    ];

    protected $casts    = [
        'image' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
