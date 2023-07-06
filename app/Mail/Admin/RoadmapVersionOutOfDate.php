<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoadmapVersionOutOfDate extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $receiver
    ) {
    }

    public function build(): self
    {
        return $this
            ->to($this->receiver['email'], $this->receiver['name'])
            ->subject('There is a new version of the roadmap software')
            ->markdown('emails.admin.roadmap-version-out-of-date');
    }
}
