<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_report_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // The user who generated the report
            $table->json('sections');              // Sections included in the report (deposits, withdrawals, etc.)
            $table->string('file_path')->nullable(); // Optional: if storing file path or filename
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_report_logs');
    }
}
