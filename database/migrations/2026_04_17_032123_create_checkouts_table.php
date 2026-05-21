 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            // ربط الشيك أوت بالموعد
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            // سعر الكشف
            $table->decimal('amount', 8, 2); 
            // حالة الدفع (مثلاً: مدفوع أو غير مدفوع)
            $table->string('status')->default('pending');
            // طريقة الدفع (كاش أو فيزا)
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};