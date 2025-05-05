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
        Schema::create('trade_outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_id')->constrained()->onDelete('cascade');
            $table->decimal('percentage_change', 8, 2); // e.g., +5.75% or -3.50%
            $table->text('description')->nullable(); // optional notes about the trade
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_outcomes');
    }
};
