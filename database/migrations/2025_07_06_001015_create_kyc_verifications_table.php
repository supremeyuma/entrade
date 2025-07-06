<?php

// database/migrations/xxxx_xx_xx_create_kyc_verifications_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kyc_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();
            $table->enum('status', ['not_submitted', 'pending', 'verified', 'rejected'])->default('not_submitted');
            $table->text('rejection_reason')->nullable();
            $table->string('id_document')->nullable();          // path to uploaded file
            $table->string('proof_of_address')->nullable();     // path to uploaded file
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kyc_verifications');
    }
};
