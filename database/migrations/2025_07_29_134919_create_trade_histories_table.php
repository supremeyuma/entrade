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
        if (! Schema::hasTable('trade_histories')) {
            Schema::create('trade_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trade_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('trader_id')->constrained()->onDelete('cascade');
                $table->decimal('amount_invested', 16, 2)->nullable();
                $table->decimal('roi', 5, 2)->nullable();
                $table->decimal('amount_returned', 16, 2)->nullable();
                $table->decimal('new_trade_balance', 16, 2)->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('trade_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('trade_histories', 'trade_id')) {
                $table->foreignId('trade_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('trade_histories', 'amount_invested')) {
                $table->decimal('amount_invested', 16, 2)->nullable()->after('change');
            }

            if (! Schema::hasColumn('trade_histories', 'roi')) {
                $table->decimal('roi', 5, 2)->nullable()->after('amount_invested');
            }

            if (! Schema::hasColumn('trade_histories', 'amount_returned')) {
                $table->decimal('amount_returned', 16, 2)->nullable()->after('roi');
            }

            if (! Schema::hasColumn('trade_histories', 'new_trade_balance')) {
                $table->decimal('new_trade_balance', 16, 2)->nullable()->after('amount_returned');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('trade_histories')) {
            return;
        }

        Schema::table('trade_histories', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('trade_histories', 'trade_id') ? 'trade_id' : null,
                Schema::hasColumn('trade_histories', 'amount_invested') ? 'amount_invested' : null,
                Schema::hasColumn('trade_histories', 'roi') ? 'roi' : null,
                Schema::hasColumn('trade_histories', 'amount_returned') ? 'amount_returned' : null,
                Schema::hasColumn('trade_histories', 'new_trade_balance') ? 'new_trade_balance' : null,
            ]);

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
