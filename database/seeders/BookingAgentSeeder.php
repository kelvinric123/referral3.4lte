<?php

namespace Database\Seeders;

use App\Models\BookingAgent;
use App\Models\Company;
use Illuminate\Database\Seeder;

class BookingAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure we have companies first
        $companies = Company::all();
        
        if ($companies->isEmpty()) {
            $this->command->info('No companies found. Running CompanySeeder first...');
            $this->call(CompanySeeder::class);
            $companies = Company::all();
        }
        
        // Sample booking agents data
        $agents = [
            [
                'name' => 'John Doe',
                'company_id' => 1,
                'username' => 'johndoe',
                'password' => 'qmed.asia',
                'email' => 'john.doe@globalmedtravel.com',
                'phone' => '+60123456001',
                'position' => 'Senior Agent',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'company_id' => 1,
                'username' => 'janesmith',
                'password' => 'qmed.asia',
                'email' => 'jane.smith@globalmedtravel.com',
                'phone' => '+60123456002',
                'position' => 'Medical Coordinator',
                'is_active' => true,
            ],
            [
                'name' => 'Robert Chen',
                'company_id' => 2,
                'username' => 'robertchen',
                'password' => 'qmed.asia',
                'email' => 'robert.chen@asianhealthconnect.com',
                'phone' => '+60198765001',
                'position' => 'Travel Specialist',
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Wong',
                'company_id' => 2,
                'username' => 'lisawong',
                'password' => 'qmed.asia',
                'email' => 'lisa.wong@asianhealthconnect.com',
                'phone' => '+60198765002',
                'position' => 'Client Relations',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmed Khan',
                'company_id' => 3,
                'username' => 'ahmedkhan',
                'password' => 'qmed.asia',
                'email' => 'ahmed.khan@meditour.com',
                'phone' => '+60145678001',
                'position' => 'Travel Consultant',
                'is_active' => true,
            ],
        ];
        
        // Create the booking agents
        foreach ($agents as $agent) {
            // Check if company_id exists, otherwise use the first available company
            if (!$companies->contains('id', $agent['company_id'])) {
                $agent['company_id'] = $companies->first()->id;
            }
            
            BookingAgent::create($agent);
        }
    }
} 