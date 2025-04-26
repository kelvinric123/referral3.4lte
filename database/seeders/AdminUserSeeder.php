<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the user already exists
        $existingUser = User::where('email', 'drtai@qmed.asia')->first();
        if ($existingUser) {
            // Delete existing user by first detaching roles
            DB::table('user_role')->where('user_id', $existingUser->id)->delete();
            $existingUser->delete();
        }
        
        // Create super admin user
        $admin = User::create([
            'name' => 'Dr. Tai',
            'email' => 'drtai@qmed.asia',
            'password' => Hash::make('88888888'),
            'email_verified_at' => now(),
        ]);

        // Assign super admin role
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $admin->roles()->attach($superAdminRole);
        }
    }
}
