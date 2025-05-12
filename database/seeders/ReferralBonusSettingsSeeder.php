<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// database/seeders/ReferralBonusSettingsSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralBonusSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'referral_bonus_trigger_registration',
                'value' => '1',
                'description' => 'Trigger referral bonus when referred user registers',
            ],
            [
                'key' => 'referral_bonus_trigger_first_deposit',
                'value' => '1',
                'description' => 'Trigger referral bonus on referred user’s first deposit',
            ],
            [
                'key' => 'referral_bonus_trigger_every_deposit',
                'value' => '0',
                'description' => 'Trigger referral bonus on every deposit by referred user',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'description' => $setting['description']]
            );
        }
    }
}
