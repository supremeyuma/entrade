<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('site_settings')->insert([
            'key' => 'deposits_enabled',
            'value' => '1',
        ]);

        DB::table('site_settings')->insertOrIgnore([
            ['key' => 'user_reports_enable_deposits', 'value' => true, 'description' => 'Enable deposits in user reports'],
            ['key' => 'user_reports_enable_withdrawals', 'value' => true, 'description' => 'Enable withdrawals in user reports'],
            ['key' => 'user_reports_enable_trades', 'value' => true, 'description' => 'Enable trades in user reports'],
            ['key' => 'user_reports_enable_referrals', 'value' => true, 'description' => 'Enable referrals in user reports'],
        ]);
        
    }
}
