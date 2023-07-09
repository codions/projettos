<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Services\WebhookClient;
use App\Settings\ColorSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWebhookForNewTicketJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Ticket $ticket, private readonly array $receiver)
    {
    }

    public function handle()
    {
        (new WebhookClient($this->receiver['webhook']))->send('POST', $this->getPostDataForChannel());
    }

    private function getPostDataForChannel(): array
    {
        return match ($this->receiver['type']) {
            'discord' => [
                'username' => config('app.name'),
                'avatar_url' => asset('storage/favicon.png'),
                'embeds' => [
                    [
                        'title' => 'New ticket notification',
                        'description' => 'A new item with the title **' . $this->ticket->subject . '** has been created',
                        'fields' => [
                            [
                                'name' => 'URL',
                                'value' => route('support.ticket', $this->ticket->uuid),
                            ],
                        ],
                        'color' => '2278750',
                    ],
                ],
            ],
            'slack' => [
                'username' => config('app.name'),
                'icon_url' => asset('storage/favicon.png'),
                'attachments' => [
                    [
                        'fallback' => 'A new ticket has been created: <' . route('support.ticket', $this->ticket->uuid) . '|' . $this->ticket->subject . '>',
                        'pretext' => 'A new ticket has been created: <' . route('support.ticket', $this->ticket->uuid) . '|' . $this->ticket->subject . '>',
                        'color' => app(ColorSettings::class)->primary ?? '#2278750',
                        'fields' => [
                            [
                                'title' => $this->ticket->subject,
                                'value' => str($this->ticket->content)->limit(50),
                                'shorts' => false,
                            ],
                        ],
                    ],
                ],
            ],
        };
    }
}
