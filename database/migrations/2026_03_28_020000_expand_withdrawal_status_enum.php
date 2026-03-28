<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE withdrawals
            MODIFY status ENUM('unconfirmed', 'pending', 'approved', 'rejected', 'completed', 'cancelled')
            NOT NULL DEFAULT 'unconfirmed'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            UPDATE withdrawals
            SET status = 'pending'
            WHERE status IN ('unconfirmed', 'cancelled')
        ");

        DB::statement("
            ALTER TABLE withdrawals
            MODIFY status ENUM('pending', 'approved', 'rejected', 'completed')
            NOT NULL DEFAULT 'pending'
        ");
    }
};
