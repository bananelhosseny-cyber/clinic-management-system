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
// duplicated custom fields migration removed (was pasted here by mistake)
       Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('first_name'); // عشان يطابق الـ Register
    $table->string('last_name');
    $table->string('user_type');
    $table->string('email')->unique();
    $table->string('verification_code')->nullable(); // كود التحقق نص عادي
    $table->timestamp('token_expiry')->nullable();   // وقت الانتهاء
    $table->string('password');
    $table->date('birthdate');
    $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('Verification_code');
            $table->timestamp('Token_Expiry')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
