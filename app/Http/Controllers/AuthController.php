<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * عرض صفحة التسجيل
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * معالجة طلب التسجيل
     */
    public function register(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // تسجيل الدخول تلقائياً
        Auth::login($user);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('dashboard')
            ->with('success', 'مرحباً ' . $user->name . '! تم إنشاء حسابك بنجاح.');
    }

    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * معالجة طلب تسجيل الدخول
     */
    public function login(Request $request)
    {
        // التحقق من البيانات
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // إذا فشل تسجيل الدخول
        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ يرجع لصفحة تسجيل الدخول حقكم
        return redirect()->route('login')->with('status', 'تم تسجيل الخروج بنجاح.');
    }
}
