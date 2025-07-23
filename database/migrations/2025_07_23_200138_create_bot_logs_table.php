<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bot_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete(); // assuming admin is a user
            $table->foreignId('trader_id')->nullable()->constrained('traders')->nullOnDelete();
            $table->string('market'); // forex, crypto, etc
            $table->decimal('roi', 5, 2);
            $table->string('strategy')->default('ROI Simulation');
            $table->text('summary')->nullable(); // human readable summary
            $table->json('input_data')->nullable(); // all params passed
            $table->json('output_data')->nullable(); // result or list of trades
            $table->json('errors')->nullable(); // exception or warnings
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_logs');
    }
};
