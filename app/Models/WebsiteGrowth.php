<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteGrowth extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status',
    ];
    public function languages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WebsiteGrowthLanguage::class);
    }

    public function language(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(WebsiteGrowthLanguage::class, 'website_growth_id', 'id')->where('lang', app()->getLocale());
    }
}
