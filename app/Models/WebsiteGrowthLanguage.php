<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteGrowthLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_growth_id',
        'lang',
        'title',
        'description',
    ];
}
