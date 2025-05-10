<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('description')->nullable()->after('value');
        });

        $settings = [
            ['key' => 'referral_enabled', 'value' => 'false', 'description' => 'Enable or disable the referral system'],
            ['key' => 'referral_bonus_enabled', 'value' => 'false', 'description' => 'Enable or disable referral bonuses'],
            ['key' => 'referral_bonus_type', 'value' => 'flat', 'description' => 'Type of referral bonus: flat or percentage'],
            ['key' => 'referral_bonus_amount', 'value' => '10', 'description' => 'Referral bonus amount (flat or percentage)'],
            ['key' => 'referral_bonus_credit_to', 'value' => 'main', 'description' => 'Balance to credit referral bonus: main or trading'],
            ['key' => 'referral_tiered_enabled', 'value' => 'false', 'description' => 'Enable or disable tiered referral system'],
            ['key' => 'referral_link_expiry_days', 'value' => '30', 'description' => 'Number of days before referral link expires'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'description' => $setting['description'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        DB::table('site_settings')->whereIn('key', [
            'referral_enabled',
            'referral_bonus_enabled',
            'referral_bonus_type',
            'referral_bonus_amount',
            'referral_bonus_credit_to',
            'referral_tiered_enabled',
            'referral_link_expiry_days',
        ])->delete();
    }
};
