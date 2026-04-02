<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['uid', 'title', 'client_id', 'user_id', 'content', 'link', 'platform_response', 'is_scheduled', 'schedule_time', 'is_draft', 'status', 'post_type', 'images',
        'when_post', 'start_time', 'interval', 'repost_frequency', 'end_time', 'specific_times'];

    protected $casts    = [
        'images'            => 'array',
        'platform_response' => 'array',
        'specific_times'    => 'array',
    ];

    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(SocialAccount::class);
    }
	public function schedules(): HasMany
	{
        return $this->hasMany(PostSchedule::class);
    }
}
