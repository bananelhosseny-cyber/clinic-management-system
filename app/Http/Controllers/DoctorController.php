<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    // عرض كل الدكاترة
    public function index()
    {
        
        return view('Doctors');
    }

    // عرض تفاصيل دكتور
    public function show($id)
    {
        // لحد ما الداتا بيز تتعمل
        // بنبعت ال id للصفحة بس
        return view('CardiologyDetails', compact('id'));
    }

public function store(Request $request) {
    // 1. التأكد من البيانات (لو ناقصة هيرجعك أوتوماتيك لنفس الصفحة)
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required',
    ]);

    // 2. لو البيانات سليمة، هنجيب بيانات الدكتور اللي اخترتيه عشان يظهر هو مش حد تاني
    // نفترض إنك بتبعتي الـ id بتاع الدكتور في الفورم
    $doctor = Doctor::find($request->doctor_id); 
    
    // 3. نفتح صفحة الـ Checkout ونبعت لها بيانات الدكتور الصح
    return view('checkout', compact('doctor'));
}
}