<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trade_bot_configs', function (Blueprint $table) {
            $table->integer('min_trade_duration_days')->default(1)->after('max_trades');
            $table->integer('max_trade_duration_days')->default(5)->after('min_trade_duration_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_bot_configs', function (Blueprint $table) {
            $table->dropColumn('min_trade_duration_days');
            $table->dropColumn('max_trade_duration_days');
        });
    }
};