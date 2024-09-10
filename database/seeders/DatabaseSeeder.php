<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@willow.edu.mz',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
        ]);

        $role = Role::create(['name' => 'Admin']);
        $roleStudent = Role::create(['name' => 'Student']);
        $user1->assignRole($role);
    }
}
