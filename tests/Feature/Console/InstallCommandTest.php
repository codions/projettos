<?php

use App\Enums\UserRole;
use App\Models\User;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function PHPUnit\Framework\assertSame;

test('install command works', function () {
    $command = artisan('app:install')
        ->expectsOutput('Roadmap Installation')
        ->expectsConfirmation('Do you want to run the migrations to set up everything fresh? (php artisan migrate:fresh)')
        ->expectsOutput('Let\'s create a user.')
        ->expectsQuestion('Name', 'John Doe')
        ->expectsQuestion('Email address', 'johndoe@codions.io')
        ->expectsQuestion('Password', 'secret');

    if (! file_exists(public_path('storage'))) {
        $command->expectsConfirmation('Your storage does not seem to be linked, do you want me to do this?');
    }

    $command
        ->expectsConfirmation('Do you want to run npm ci & npm run production to get the assets ready?')
        ->expectsConfirmation('Would you like to show some love by starring the repo?')
        ->run();

    assertDatabaseCount(User::class, 1);

    $user = User::query()->first();
    assertSame(UserRole::Admin, $user->role, 'User should be an admin');
    assertSame('John Doe', $user->name);
    assertSame('johndoe@codions.io', $user->email);
});
