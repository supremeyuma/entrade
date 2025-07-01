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
        Schema::create('withdrawal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('cryptocurrency')->unique();
            $table->decimal('min_amount', 20, 8)->default(0.0001);
            $table->decimal('max_amount', 20, 8)->default(1000000);
            $table->decimal('fixed_fee', 20, 8)->default(0); // e.g., 0.0005 BTC
            $table->decimal('percent_fee', 5, 2)->default(0); // e.g., 1.5%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_settings');
    }
};
