<?php

namespace Database\Seeders\Demo;

use App\Enums\UserRole;
use App\Models\Item;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $employee = User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@employee.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Employee,
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::User,
        ]);

        $this->userFactory([$admin, $employee, $user]);

        User::factory()
            ->count(20)
            ->create();
    }

    private function userFactory($users)
    {
        collect($users)->each(function ($user) {
            $user->projects()->saveMany(Project::factory()->count(3)->make());
            $user->tickets()->saveMany(Ticket::factory()->count(3)->make());
            $user->items()->saveMany(Item::factory()->count(3)->make());
        });
    }
}
