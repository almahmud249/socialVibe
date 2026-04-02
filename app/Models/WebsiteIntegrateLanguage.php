<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteIntegrateLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_integrates_id',
        'lang',
        'title',
    ];
}
