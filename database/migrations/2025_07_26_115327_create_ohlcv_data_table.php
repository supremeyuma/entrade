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
        Schema::create('ohlcv_data', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('market_type');
            $table->string('interval'); // e.g., 1min, 1d
            $table->timestamp('timestamp')->unique(); // Unique for a given symbol/interval
            $table->float('open');
            $table->float('high');
            $table->float('low');
            $table->float('close');
            $table->float('volume');
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ohlcv_data');
    }
};