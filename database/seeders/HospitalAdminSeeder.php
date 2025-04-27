<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HospitalAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if hospital-admin role exists, create it if not
        $role = Role::firstOrCreate(
            ['slug' => 'hospital-admin'],
            [
                'name' => 'Hospital Admin',
                'description' => 'Hospital administrator with access to hospital resources'
            ]
        );

        // Create the hospital
        $hospital = Hospital::firstOrCreate(
            ['email' => 'qmed.asia'],
            [
                'name' => 'QMed Hospital',
                'email' => 'qmed.asia',
                'password' => 'qmed.asia',
                'is_active' => true
            ]
        );

        // Create the user for hospital admin
        $user = User::firstOrCreate(
            ['email' => 'qmed.asia'],
            [
                'name' => 'Hospital Admin',
                'email' => 'qmed.asia',
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
