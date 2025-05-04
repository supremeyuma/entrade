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
    }
}
