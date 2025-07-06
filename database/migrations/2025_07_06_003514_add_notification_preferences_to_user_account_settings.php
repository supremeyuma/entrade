<?php

// database/migrations/xxxx_xx_xx_add_notification_preferences_to_user_account_settings.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('user_account_settings', function (Blueprint $table) {
            $table->boolean('notify_on_trade_activity')->default(true);
            $table->boolean('notify_on_withdrawal')->default(true);
            $table->boolean('notify_on_referral')->default(true);
        });
    }

    public function down(): void {
        Schema::table('user_account_settings', function (Blueprint $table) {
            $table->dropColumn([
                'notify_on_trade_activity',
                'notify_on_withdrawal',
                'notify_on_referral',
            ]);
        });
    }
};
