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
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->string('icon_type')->default('emoji'); // emoji, icon, image
            $table->string('icon_value')->nullable(); // emoji or file path or icon class
            $table->text('description')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            //
        });
    }
};
