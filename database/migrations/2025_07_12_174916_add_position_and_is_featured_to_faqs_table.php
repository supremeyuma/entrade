<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('faqs', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('faq_category_id');
            $table->boolean('is_featured')->default(false)->after('position');
        });
    }

    public function down(): void {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['position', 'is_featured']);
        });
    }
};
