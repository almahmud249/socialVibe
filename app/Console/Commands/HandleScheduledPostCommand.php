<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Traits\FacebookAccountTrait;
use App\Traits\InstagramAccountTrait;
use App\Traits\LinkedInAccountTrait;
use App\Traits\TwitterAccountTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HandleScheduledPostCommand extends Command
{
    use FacebookAccountTrait, InstagramAccountTrait, LinkedInAccountTrait, TwitterAccountTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'handle:scheduled-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $posts = Post::with('accounts', 'schedules')->whereHas('schedules', function ($query) {
            $query->where('start_time', '<=', Carbon::now()->format('Y-m-d H:i:s'));
        })->whereIn('when_post', [2, 3])->get();

        foreach ($posts as $post) {
            $post_schedule = $post->schedules->where('start_time', '<=', Carbon::now()->format('Y-m-d H:i:s'))->first();

            if ($post_schedule) {
                $status                  = false;
                $response                = [];
                foreach ($post->accounts as $key => $account) {
                    if ($key > 1 && $post->when_post == 2) {
                        sleep($post_schedule->interval * 60);
                    }
                    if ($account->details == 'facebook') {
                        $response['facebook'] = $this->handlePost($account, $post, true);
                        $status               = $response['facebook']['status'];
                    } elseif ($account->details == 'instagram') {
                        $response['instagram'] = $this->instagramHandlePost($account, $post);
                        $status                = $response['instagram']['status'];
                    } elseif ($account->details == 'twitter') {
                        try {
                            $response['twitter'] = $this->twitterFeed($account, $post);
                            $status              = $response['twitter']['status'];
                        } catch (\Exception $e) {
                            $status = false;
                        }
                    } elseif ($account->details == 'linkedin') {
                        $response['linkedin'] = $this->linkedInFeed($account, $post);
                        $status               = $response['linkedin']['status'];
                    }
                }
                $post->status            = $status;
                $post->platform_response = $response;
                $post->save();
                $post_schedule->delete();
            }
        }

        return Command::SUCCESS;
    }
}
