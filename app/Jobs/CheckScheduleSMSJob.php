<?php

namespace App\Jobs;

use App\Traits\SMSTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckScheduleSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SMSTrait;

    protected $smsId;

    public function __construct($smsId)
    {
        $this->smsId = $smsId;
    }

    public function handle()
    {
        $this->checkMessageStatusAndUpdate($this->smsId, $provider = '');

    }
}
