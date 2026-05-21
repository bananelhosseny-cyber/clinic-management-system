<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        
            Schema::table('appointments', function (Blueprint $table) {
                // 1. Add the two new dedicated columns
                if (!Schema::hasColumn('appointments', 'date')) {
                $table->date('date')->nullable()->after('patient_id');
                $table->time('time')->nullable()->after('date');
                }
        });

        // 2. Migrate existing data from appointment_date → date + time
        DB::statement("
            UPDATE appointments
            SET
                `date` = DATE(CONVERT_TZ(appointment_date, '+00:00', '+02:00')),
                `time` = TIME(CONVERT_TZ(appointment_date, '+00:00', '+02:00'))
            WHERE appointment_date IS NOT NULL
        ");

        Schema::table('appointments', function (Blueprint $table) {
            // 3. Make columns required now that data is migrated
            $table->date('date')->nullable(false)->change();
            $table->time('time')->nullable(false)->change();

            // 4. Convert status from varchar to ENUM
            // Note: use DB::statement because Blueprint::enum() on existing columns
            // requires dropping and re-adding in some MySQL versions.
        });

        // 5. Alter status to proper ENUM
        DB::statement("ALTER TABLE appointments MODIFY COLUMN `status` ENUM('pending','approved','cancelled') NOT NULL DEFAULT 'pending'");

        // 6. Update legacy status values to match our new enum
        DB::statement("UPDATE appointments SET `status` = 'approved'  WHERE `status` = 'confirm'");
        DB::statement("UPDATE appointments SET `status` = 'approved'  WHERE `status` = 'confirmed'");
        DB::statement("UPDATE appointments SET `status` = 'approved'  WHERE `status` = 'complete'");
        DB::statement("UPDATE appointments SET `status` = 'cancelled' WHERE `status` = 'cancel'");

        // 7. Add composite unique index to prevent double-booking at DB level
        Schema::table('appointments', function (Blueprint $table) {
            // Partial unique: only one non-cancelled booking per slot
            // MySQL doesn't support partial indexes; we enforce this in PHP and
            // add a plain composite index for fast lookups.
            $table->index(['doctor_id', 'date', 'time'], 'idx_doctor_date_time');
        });

        // 8. Drop old appointment_date column (keep as nullable first for safety)
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('appointment_date');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('appointment_date')->nullable()->after('patient_id');
        });

        DB::statement("
            UPDATE appointments
            SET appointment_date = CONVERT_TZ(CONCAT(`date`, ' ', `time`), '+02:00', '+00:00')
        ");

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('idx_doctor_date_time');
            $table->dropColumn(['date', 'time']);
        });

        DB::statement("ALTER TABLE appointments MODIFY COLUMN `status` VARCHAR(255) NOT NULL DEFAULT 'pending'");
    }
};
