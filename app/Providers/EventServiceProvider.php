<?php

namespace App\Providers;

use App\Models\Changelog;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vote;
use App\Observers\ChangelogObserver;
use App\Observers\CommentObserver;
use App\Observers\ItemObserver;
use App\Observers\ProjectObserver;
use App\Observers\TicketObserver;
use App\Observers\UserObserver;
use App\Observers\VoteObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        Vote::class => [VoteObserver::class],
        Project::class => [ProjectObserver::class],
        Item::class => [ItemObserver::class],
        Ticket::class => [TicketObserver::class],
        Comment::class => [CommentObserver::class],
        User::class => [UserObserver::class],
        Changelog::class => [ChangelogObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
