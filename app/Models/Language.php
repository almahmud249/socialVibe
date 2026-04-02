<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'locale', 'flag', 'is_default', 'text_direction', 'status'];

    public function flag(): HasOne
    {
        return $this->hasOne(FlagIcon::class, 'title', 'locale');
    }

    public function getFlagIconAttribute()
    {
        return $this->flag ? static_asset($this->flag->image) : static_asset('images/flags/ad.png');
    }
}
