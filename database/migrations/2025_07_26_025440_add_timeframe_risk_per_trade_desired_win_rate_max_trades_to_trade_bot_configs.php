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
            //
            $table->enum('timeframe', ['1h', '4h', '1d'])->default('1d');
            $table->decimal('risk_per_trade', 5, 2)->default(1.00); // as percentage
            $table->decimal('desired_win_rate', 5, 2)->nullable(); // 0–100%
            $table->integer('max_trades')->nullable(); // optional cap

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_bot_configs', function (Blueprint $table) {
            //
        });
    }
};
