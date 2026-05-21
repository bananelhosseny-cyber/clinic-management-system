<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginDetail extends Model
{
    // بما إننا عملنا الجدول بالميجرايشن واسمه login_details ف السطر ده اختياري بس خليه للأمان
    protected $table = 'login_details';

    protected $fillable = ['email', 'login_at'];

    // لارفيل بيضيف created_at و updated_at أوتوماتيك طالما سبنا $table->timestamps() في الميجرايشن
    public $timestamps = true;
}
