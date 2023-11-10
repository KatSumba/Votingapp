<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory()
            ->count(20) // Number of users you want to create
            ->create([
                'Role' => '0', // Assigning '0' to the Role field for the first 10 users
                'EnrollmentStatus' => 'active', // Assigning 'active' to the EnrollmentStatus for the first 10 users
            ]);

        User::factory()
            ->count(2) // Number of users you want to create
            ->create([
                'Role' => '1', // Assigning '1' to the Role field for the next 10 users
                'EnrollmentStatus' => 'inactive', // Assigning 'inactive' to the EnrollmentStatus for the next 10 users
            ]);
    }
}
