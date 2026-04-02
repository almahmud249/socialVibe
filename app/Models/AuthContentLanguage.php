<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthContentLanguage extends Model
{
    use HasFactory;
    protected $fillable = [
        'auth_content_id',
        'lang',
        'title',
    ];
}
