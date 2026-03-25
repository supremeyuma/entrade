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
        if (! Schema::hasTable('user_trader_subscriptions') && Schema::hasTable('user_trader_subscription')) {
            Schema::rename('user_trader_subscription', 'user_trader_subscriptions');
        }

        Schema::table('user_trader_subscriptions', function (Blueprint $table) {
            $table->decimal('allocated_amount', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_trader_subscriptions', function (Blueprint $table) {
            $table->decimal('allocated_amount', 10, 2)->nullable(false)->change();
        });

        if (! Schema::hasTable('user_trader_subscription') && Schema::hasTable('user_trader_subscriptions')) {
            Schema::rename('user_trader_subscriptions', 'user_trader_subscription');
        }
    }
};
