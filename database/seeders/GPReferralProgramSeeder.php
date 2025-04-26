<?php

namespace Database\Seeders;

use App\Models\GPReferralProgram;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GPReferralProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Reduce Waiting Time with Qmed Referral System',
                'description' => '<p>This short video demonstrates how the Qmed referral system helps reduce waiting time for patients and improves efficiency for healthcare providers.</p><p>Learn how our streamlined process makes referrals easier and faster for everyone involved.</p>',
                'publish_date' => Carbon::now()->subDays(30),
                'youtube_link' => 'https://www.youtube.com/shorts/xmKyxokZ_zM',
                'is_active' => true,
            ],
            [
                'title' => 'Qmed AI: Revolutionizing Medical Referrals',
                'description' => '<p>Discover how Qmed AI is transforming the medical referral process with intelligent automation and smart patient matching.</p><p>Our AI-powered system helps doctors match patients with the right specialists quickly and accurately.</p>',
                'publish_date' => Carbon::now()->subDays(15),
                'youtube_link' => 'https://www.youtube.com/watch?v=q6C6epNNbpM&t=1s',
                'is_active' => true,
            ],
            [
                'title' => 'Introducing Qmed Kiosk: Self-Service Referrals',
                'description' => '<p>The Qmed Kiosk provides a convenient self-service option for patients needing referrals.</p><p>This video showcases how patients can check in, update information, and manage their referrals without waiting in line.</p>',
                'publish_date' => Carbon::now()->subDays(7),
                'youtube_link' => 'https://www.youtube.com/watch?v=vqkF0Cp9lUA',
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            GPReferralProgram::create($program);
        }

        $this->command->info('GP Referral Programs seeded successfully.');
    }
}
