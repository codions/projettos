<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\CanShowAnIntro;
use App\Enums\UserRole;
use App\Models\User;
use Filament\Support\Commands\Concerns\CanValidateInput;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Install extends Command
{
    use CanValidateInput;
    use CanShowAnIntro;

    protected $signature = 'app:install
        {--demo : Install sample data}
        {--force : Force install with new data}';

    protected $description = 'Install Roadmap software.';

    public function handle()
    {
        $demo = $this->option('demo');
        $force = $this->option('force');

        $this->intro();
        $this->refreshDatabase($force, $demo);

        if (!$demo) {
            $this->createUser();
        }

        $this->linkStorage();

        $this->writeSeparationLine();
        $this->line(' ');

        $this->info('All done! You can now login at ' . route('filament.auth.login'));
    }

    protected function refreshDatabase($force, $demo)
    {
        if ($force) {
            $this->call('db:wip');
        }

        $this->call('migrate');

        $this->info('Installing initial data...');
        $this->call('db:seed', ['--class' => \Database\Seeders\DatabaseSeeder::class, '--force' => true]);

        if ($demo) {
            $this->call('db:seed', ['--class' => \Database\Seeders\DemoSeeder::class, '--force' => true]);
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
        if (! file_exists(public_path('storage')) && $this->confirm('Your storage does not seem to be linked, do you want me to do this?')) {
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
