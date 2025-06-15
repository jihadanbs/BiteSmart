<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrator sistem']);
        Role::create(['name' => 'caterer', 'description' => 'Pemilik catering']);
        Role::create(['name' => 'driver', 'description' => 'DrKurir pengantar makananiver']);
        Role::create(['name' => 'user', 'description' => 'Pengguna aplikasi']);
    }
}
