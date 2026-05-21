<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // جلب جميع التدوينات من قاعدة البيانات
        $posts = Post::all();

        // إرسال البيانات إلى ملف view اسمه 'posts.index'
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        // 2. إنشاء سجل جديد في قاعدة البيانات
        Post::create($validated);

        // 3. إعادة توجيه المستخدم بعد الحفظ
        return redirect('/posts')->with('success', 'تم إنشاء التدوينة بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
