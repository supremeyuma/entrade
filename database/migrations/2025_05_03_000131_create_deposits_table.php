<?php

// database/migrations/xxxx_xx_xx_create_deposits_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 16, 8);
            $table->string('currency', 10)->default('USDT'); // Default to USDT, can be expanded
            $table->string('gateway')->default('Plisio');
            $table->string('payment_address')->nullable();
            $table->string('txn_id')->nullable(); // Plisio transaction ID
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
}

