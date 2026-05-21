<?php
namespace App\Models;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; // 1. تأكدي من وجود السطر ده
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable ,HasFactory; // 2. تأكدي إنك كاتبة HasApiTokens هنا

    // باقي الكود بتاعك...


    protected $table = 'users';

    // الأعمدة اللي مسموح يتبعتلها داتا
    protected $fillable = [
    'first_name',
    'last_name',
    'user_type',
    'email',
    'password',
    'birthdate',
    'verification_code', // ضيفي ده
    'token_expiry'       // وضيفي ده
];


    // إخفاء الباسوردnamespace App\Models;


  protected $hidden = [
        'password',
    ];

    // لو birthdate تاريخ
    protected $casts = [
        'birthdate' => 'date',
        'token_expiry' => 'datetime',
    ];
}

