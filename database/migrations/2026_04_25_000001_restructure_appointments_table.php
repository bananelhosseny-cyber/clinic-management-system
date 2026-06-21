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
            if (!Schema::hasColumn('appointments', 'date')) {
                $table->date('date')->nullable()->after('patient_id');
                $table->time('time')->nullable()->after('date');
            }
        });

        // Migrate data - works on both MySQL and SQLite
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("
                UPDATE appointments
                SET
                    `date` = DATE(CONVERT_TZ(appointment_date, '+00:00', '+02:00')),
                    `time` = TIME(CONVERT_TZ(appointment_date, '+00:00', '+02:00'))
                WHERE appointment_date IS NOT NULL
            ");
        } else {
            DB::statement("
                UPDATE appointments
                SET
                    `date` = DATE(appointment_date),
                    `time` = TIME(appointment_date)
                WHERE appointment_date IS NOT NULL
            ");
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->date('date')->nullable(false)->change();
            $table->time('time')->nullable(false)->change();
        });

        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE appointments MODIFY COLUMN `status` ENUM('pending','approved','cancelled') NOT NULL DEFAULT 'pending'");
            DB::statement("UPDATE appointments SET `status` = 'approved'  WHERE `status` IN ('confirm','confirmed','complete')");
            DB::statement("UPDATE appointments SET `status` = 'cancelled' WHERE `status` = 'cancel'");
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->index(['doctor_id', 'date', 'time'], 'idx_doctor_date_time');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('appointment_date');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('appointment_date')->nullable()->after('patient_id');
        });

        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("UPDATE appointments SET appointment_date = CONVERT_TZ(CONCAT(`date`, ' ', `time`), '+02:00', '+00:00')");
        } else {
            DB::statement("UPDATE appointments SET appointment_date = CONCAT(`date`, ' ', `time`)");
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('idx_doctor_date_time');
            $table->dropColumn(['date', 'time']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE appointments MODIFY COLUMN `status` VARCHAR(255) NOT NULL DEFAULT 'pending'");
        }
    }
};
        DB::statement("ALTER TABLE appointments MODIFY COLUMN `status` VARCHAR(255) NOT NULL DEFAULT 'pending'");
    }
};
