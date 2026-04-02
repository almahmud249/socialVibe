<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_period',
        'is_free',
        'profile_limit',
        'color',
        'post_limit',
        'featured',
        'team_limit',
        'status',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = date('Y-m-d H:i:s');
        });
        static::updating(function ($model) {
            $model->updated_at = date('Y-m-d H:i:s');
        });
    }
}
