<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Console\Commands\Concerns\CanShowAnIntro;
use Filament\Support\Commands\Concerns\CanValidateInput;

class Install extends Command
{
    use CanValidateInput, CanShowAnIntro;

    protected $signature = 'roadmap:install';

    protected $description = 'Install Roadmap software.';

    public function handle()
    {
        $this->intro();
        $this->refreshDatabase();
        $this->createUser();
        $this->linkStorage();

        $this->writeSeparationLine();
        $this->line(' ');

        $this->info('All done! You can now login at ' . route('filament.auth.login'));
    }

    protected function refreshDatabase()
    {
        if ($this->confirm('Do you want to run the migrations to set up everything fresh? (php artisan migrate:fresh)')) {
            $this->call('migrate:fresh');
        }
    }

    protected function createUser()
    {
        $this->info('Let\'s create a user.');

        $user = User::create($this->getUserData());
        $user->role = UserRole::Admin;
        $user->email_verified_at = now();
        $user->save();

        $this->info('User created!');

        return $user;
    }

    protected function linkStorage()
    {
        if (!file_exists(public_path('storage')) && $this->confirm('Your storage does not seem to be linked, do you want me to do this?')) {
            $this->call('storage:link');
        }
    }


    protected function getUserData(): array
    {
        return [
            'name' => $this->validateInput(fn () => $this->ask('Name', 'Admin'), 'name', ['required']),
            'email' => $this->validateInput(fn () => $this->ask('Email address', 'admin@admin.com'), 'email', ['required', 'email', 'unique:' . User::class]),
            'password' => Hash::make($this->validateInput(fn () => $this->secret('Password'), 'password', ['required', 'min:6'])),
        ];
    }
}
