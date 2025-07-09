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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['credit', 'debit']);
            $table->enum('balance_type', ['main', 'trading']);
            $table->enum('category', ['deposit', 'withdrawal', 'bonus', 'trade', 'adjustment']);
            $table->decimal('amount', 20, 8);
            $table->text('user_note')->nullable();  // visible to user
            $table->text('admin_note')->nullable(); // visible only to admin
            $table->json('meta')->nullable();       // optional for flexibility
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
