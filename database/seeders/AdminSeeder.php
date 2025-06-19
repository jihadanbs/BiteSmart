<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat atau cari user dengan email admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@bitesmart.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('PasswordSuperAman123!'),
            ]
        );

        // Beri Peran Aplikasi 'admin'
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        // Buat tim personal untuk admin agar Jetstream tidak error
        // Admin akan menjadi pemilik (owner) dari tim ini.
        if ($adminUser->ownedTeams->isEmpty()) {
            $adminUser->ownedTeams()->save(Team::forceCreate([
                'user_id' => $adminUser->id,
                'name' => "Admin's Team",
                'personal_team' => true,
            ]));
        }
    }
}
