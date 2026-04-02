<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodayScheduledPostService
{
    public function execute(Request $request)
    {
        $posts    = PostSchedule::whereDate('start_time', Carbon::today())->get();

        $hours    = range(0, 23);
        $data     = [];

        $facebook = $instagram = $linkedin = $twitter = $tiktok = [];

        foreach ($hours as $hour) {
            $filtered = $posts->filter(function ($post) use ($hour,$facebook , $instagram , $linkedin , $twitter , $tiktok) {
                $bool = Carbon::parse($post->start_time)->format('H') == str_pad($hour, 2, '0', STR_PAD_LEFT);
                if ($bool) {
                    foreach ($post->social_accounts as $social_account) {
                        $$social_account[] = 0;
                    }
                }
                return $bool;
            });
            $data[] = count($filtered->toArray());
        }

        return [
            'labels'    => array_map(fn ($hour) => str_pad($hour, 2, '0', STR_PAD_LEFT).':00', $hours),
            'facebook'  => $data,
            'instagram' => $data,
            'linkedin'  => $data,
            'x'         => $data,
        ];
    }
}
