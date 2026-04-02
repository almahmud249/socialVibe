<?php

namespace App\Services;

use App\Models\Post;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduledPostService
{
    private $data = [];

    public function execute(Request $request)
    {
        /*$query = Post::select(
            DB::raw('DATE(schedule_time) as scheduled_date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('schedule_time', [Carbon::now(), Carbon::now()->addDays(30)])
            ->groupBy(DB::raw('DATE(schedule_time)'))
            ->orderBy(DB::raw('DATE(schedule_time)'))
            ->get();*/
		$query = collect();

        $startPeriod = Carbon::now();
        $endPeriod = Carbon::now()->addDays(30);
        $period = CarbonPeriod::create($startPeriod, '1 day', $endPeriod);

        $dates = [];
        $data = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('M-d');
            $dates[] = $formattedDate;
            $post = $query->where('scheduled_date', $formattedDate)->first();
            $data[] = $post ? $post->count : 0;
        }

        return [
            'labels' => $dates,
            'facebook' => $data,
            'instagram' => $data,
            'linkedin' => $data,
            'x' => $data,
        ];
    }
}
