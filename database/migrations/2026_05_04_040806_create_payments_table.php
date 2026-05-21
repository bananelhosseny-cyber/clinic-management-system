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
        Schema::create('payments', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments');
            $table->foreignId('patient_id')->constrained('users');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('city');
            $table->string('address');
            $table->string('payment_method');
            $table->decimal('amount', 8, 2)->default(200.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('payments');
}
};