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
        if (! Schema::hasTable('kyc_verifications')) {
            Schema::create('kyc_verifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();
                $table->string('phone')->nullable();
                $table->string('country')->nullable();
                $table->string('address')->nullable();
                $table->string('identification_type')->nullable();
                $table->string('identification_number')->nullable();
                $table->string('passport_number')->nullable();
                $table->string('id_document')->nullable();
                $table->string('proof_of_address')->nullable();
                $table->string('passport_document')->nullable();
                $table->enum('status', ['not_submitted', 'pending', 'verified', 'rejected'])->default('not_submitted');
                $table->text('rejection_reason')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('kyc_verifications', function (Blueprint $table) {
            if (! Schema::hasColumn('kyc_verifications', 'phone')) {
                $table->string('phone')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('kyc_verifications', 'country')) {
                $table->string('country')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('kyc_verifications', 'address')) {
                $table->string('address')->nullable()->after('country');
            }

            if (! Schema::hasColumn('kyc_verifications', 'identification_type')) {
                $table->string('identification_type')->nullable()->after('address');
            }

            if (! Schema::hasColumn('kyc_verifications', 'identification_number')) {
                $table->string('identification_number')->nullable()->after('identification_type');
            }

            if (! Schema::hasColumn('kyc_verifications', 'passport_number')) {
                $table->string('passport_number')->nullable()->after('identification_number');
            }

            if (! Schema::hasColumn('kyc_verifications', 'proof_of_address')) {
                $table->string('proof_of_address')->nullable()->after('id_document');
            }

            if (! Schema::hasColumn('kyc_verifications', 'passport_document')) {
                $table->string('passport_document')->nullable()->after('proof_of_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('kyc_verifications')) {
            return;
        }

        Schema::table('kyc_verifications', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('kyc_verifications', 'phone') ? 'phone' : null,
                Schema::hasColumn('kyc_verifications', 'country') ? 'country' : null,
                Schema::hasColumn('kyc_verifications', 'address') ? 'address' : null,
                Schema::hasColumn('kyc_verifications', 'identification_type') ? 'identification_type' : null,
                Schema::hasColumn('kyc_verifications', 'identification_number') ? 'identification_number' : null,
                Schema::hasColumn('kyc_verifications', 'passport_number') ? 'passport_number' : null,
                Schema::hasColumn('kyc_verifications', 'proof_of_address') ? 'proof_of_address' : null,
                Schema::hasColumn('kyc_verifications', 'passport_document') ? 'passport_document' : null,
            ]);

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
