<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HospitalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the hospital-admin role or create it if it doesn't exist
        $role = Role::firstOrCreate(
            ['slug' => 'hospital-admin'],
            [
                'name' => 'Hospital Admin',
                'description' => 'Hospital administrator with access to hospital resources'
            ]
        );

        // Get all hospitals
        $hospitals = Hospital::all();

        foreach ($hospitals as $hospital) {
            // Create a user for each hospital
            $user = User::firstOrCreate(
                ['email' => $hospital->email],
                [
                    'name' => $hospital->name . ' Admin',
                    'email' => $hospital->email,
                    'password' => Hash::make('qmed.asia'),
                    'active' => true
                ]
            );

            // Assign hospital-admin role to the user if not already assigned
            if (!$user->hasRole('hospital-admin')) {
                $user->roles()->attach($role);
            }
        }
    }
}
