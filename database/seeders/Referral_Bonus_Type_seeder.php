<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Referral_Bonus_Type_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('site_settings')->insert([
            [
                'key' => 'referral_bonus_type',
                'value' => 'percentage',
                'description' => 'Type of referral bonus: fixed or percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referral_bonus_value',
                'value' => '5',
                'description' => 'Value of referral bonus. If percentage, input percent value; if fixed, input fixed amount.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
