<?php

// database/migrations/xxxx_xx_xx_create_user_account_settings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_account_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('language')->nullable();
            $table->string('timezone')->nullable();
            $table->boolean('email_notifications')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_account_settings');
    }
};
