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
        Schema::table('trades', function (Blueprint $table) {
            $table->string('pair')->after('asset')->nullable();
            $table->decimal('lot_size', 10, 2)->after('exit_price')->nullable();
            $table->decimal('stop_loss', 20, 8)->nullable()->after('lot_size');
            $table->decimal('take_profit', 20, 8)->nullable()->after('stop_loss');
            $table->dateTime('opened_at')->nullable()->after('take_profit');
            $table->dateTime('closed_at')->nullable()->after('opened_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            //
        });
    }
};
