<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            if (!Schema::hasColumn('deposits', 'received_amount')) {
                $table->decimal('received_amount', 16, 8)->nullable()->after('amount');
            }

            if (!Schema::hasColumn('deposits', 'admin_comment')) {
                $table->text('admin_comment')->nullable()->after('status');
            }

            if (!Schema::hasColumn('deposits', 'invoice_id')) {
                $table->string('invoice_id')->nullable()->after('payment_address');
            }

            if (!Schema::hasColumn('deposits', 'invoice_url')) {
                $table->string('invoice_url')->nullable()->after('invoice_id');
            }

            if (!Schema::hasColumn('deposits', 'pay_address')) {
                $table->string('pay_address')->nullable()->after('invoice_url');
            }

            if (!Schema::hasColumn('deposits', 'credited')) {
                $table->boolean('credited')->default(false)->after('received_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            if (Schema::hasColumn('deposits', 'received_amount')) {
                $table->dropColumn('received_amount');
            }
            if (Schema::hasColumn('deposits', 'admin_comment')) {
                $table->dropColumn('admin_comment');
            }
            if (Schema::hasColumn('deposits', 'invoice_id')) {
                $table->dropColumn('invoice_id');
            }
            if (Schema::hasColumn('deposits', 'invoice_url')) {
                $table->dropColumn('invoice_url');
            }
            if (Schema::hasColumn('deposits', 'pay_address')) {
                $table->dropColumn('pay_address');
            }
            if (Schema::hasColumn('deposits', 'credited')) {
                $table->dropColumn('credited');
            }
        });
    }
};
