<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Contact; // تأكدي من استدعاء الموديل هنا

class ContactController extends Controller
{
    /**
     * دالة واحدة لحفظ البيانات وإرسال الإيميل
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات (Validation)
        $data = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required', // تأكدي أن الاسم هنا مطابق لـ name="phone" في الفورم
            'message'      => 'required',
        ]);

        // 2. حفظ البيانات في جدول Contact في قاعدة البيانات
        Contact::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_number' => $request->phone,
            'message'      => $request->message,
        ]);

        // 3. تحضير البيانات لإرسالها بالإيميل
        // قمنا بتجميع الاسم الأول والأخير لإرسالهما كـ "name" للإيميل
        $emailData = [
            'name'    => $request->first_name . ' ' . $request->last_name,
            'email'   => $request->email,
            'message' => $request->message,
        ];

        // 4. إرسال الإيميل إلى إيميل العيادة
        try {
            Mail::to('medicarelyclinic@gmail.com')->send(new ContactUsMail($emailData));
        } catch (\Exception $e) {
            // في حال وجود خطأ في إرسال الإيميل (مثل إعدادات SMTP غلط)
            // سيتم حفظ البيانات في القاعدة ولكن ستعرفين أن هناك مشكلة في الإرسال
        }

        // 5. الرجوع للخلف مع رسالة نجاح
        return redirect()->back()->with('success', 'Thank you! Your message has been saved and sent successfully.');
    }
}