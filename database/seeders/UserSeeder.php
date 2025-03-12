<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $clientRole = Role::where('name', 'client')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $gestionnaireRole = Role::where('name', 'gestionnaire')->first();

        // Create users
        $users = [
            [
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => Hash::make('password'),
                'role' => $clientRole
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => $adminRole
            ],
            [
                'name' => 'Gestionnaire User',
                'email' => 'gestionnaire@example.com',
                'password' => Hash::make('password'),
                'role' => $gestionnaireRole
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            $user->roles()->attach($userData['role']);
        }
    }
}
