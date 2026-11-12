<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * عرض صفحة الإعدادات
     */
    public function index()
    {
        $user = Auth::user();
        
        // استخدام الطريقة الصحيحة
        $systemSettings = Setting::getAllSettings();

        return view('settings.index', compact('user', 'systemSettings'));
    }

    /**
     * تحديث معلومات الحساب
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'required|string|max:20',
        ], [
            'first_name.required' => 'الاسم الأول مطلوب',
            'last_name.required'  => 'اسم العائلة مطلوب',
            'email.required'      => 'البريد الإلكتروني مطلوب',
            'email.email'         => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique'        => 'البريد الإلكتروني مستخدم بالفعل',
            'phone.required'      => 'رقم الهاتف مطلوب',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $user->name  = trim($request->first_name . ' ' . $request->last_name);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث بيانات الحساب بنجاح',
                'data'    => [
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                    'email'      => $request->email,
                    'phone'      => $request->phone
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث البيانات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تغيير كلمة المرور
     */
  public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => [
            'required',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ],
    ], [
        'current_password.required' => 'كلمة المرور الحالية مطلوبة',
        'new_password.required'     => 'كلمة المرور الجديدة مطلوبة',
        'new_password.min'          => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
        'new_password.confirmed'    => 'كلمتا المرور غير متطابقتين',
        'new_password.regex'        => 'يجب أن تحتوي كلمة المرور على حرف كبير وصغير ورقم ورمز خاص',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    $user = Auth::user();

    // التحقق من كلمة المرور الحالية
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'success' => false,
            'errors'  => [
                'current_password' => ['كلمة المرور الحالية غير صحيحة']
            ]
        ], 422);
    }

    try {
        // تحديث كلمة المرور
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تغيير كلمة المرور بنجاح'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ أثناء تغيير كلمة المرور: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * حفظ إعدادات النظام
     */
    public function saveSystemSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name'          => 'required|string|max:255',
            'store_phone'         => 'nullable|string|max:20',
            'store_email'         => 'nullable|email|max:255',
            'store_address'       => 'nullable|string',
            'currency'            => 'required|in:SAR,USD,EUR,EGP,AED',
            'date_format'         => 'required|in:DD/MM/YYYY,MM/DD/YYYY,YYYY-MM-DD',
            'time_format'         => 'required|in:12h,24h',
            'language'            => 'required|in:ar,en',
            'tax_rate'            => 'required|numeric|min:0|max:100',
            'expiry_warning_days' => 'required|integer|min:1|max:365',
            'low_stock_threshold' => 'required|integer|min:1|max:1000',
        ], [
            'store_name.required' => 'اسم المتجر مطلوب',
            'currency.required'   => 'العملة مطلوبة',
            'tax_rate.required'   => 'نسبة الضريبة مطلوبة',
            'tax_rate.numeric'    => 'نسبة الضريبة يجب أن تكون رقمًا',
            'tax_rate.min'        => 'نسبة الضريبة يجب أن تكون 0 أو أكثر',
            'tax_rate.max'        => 'نسبة الضريبة يجب أن تكون 100 أو أقل',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // تحويل البيانات إلى مصفوفة
            $settingsData = $request->only([
                'store_name', 'store_phone', 'store_email', 'store_address',
                'currency', 'date_format', 'time_format', 'language',
                'tax_rate', 'expiry_warning_days', 'low_stock_threshold'
            ]);

            // تحويل الأرقام إلى نص
            $settingsData['tax_rate'] = strval($settingsData['tax_rate']);
            $settingsData['expiry_warning_days'] = strval($settingsData['expiry_warning_days']);
            $settingsData['low_stock_threshold'] = strval($settingsData['low_stock_threshold']);

            Setting::saveAllSettings($settingsData);

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات النظام بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الإعدادات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على بيانات الحساب (لإعادة تعيين النموذج)
     */
    public function getProfileData()
    {
        $user = Auth::user();

        $nameParts = explode(' ', $user->name, 2);

        return response()->json([
            'success' => true,
            'data' => [
                'first_name' => $nameParts[0] ?? '',
                'last_name'  => $nameParts[1] ?? '',
                'email'      => $user->email,
                'phone'      => $user->phone ?? '',
                'username'   => $user->username ?? $user->email,
                'role'       => 'مدير النظام'
            ]
        ]);
    }

    /**
     * الحصول على إعدادات النظام (لإعادة تعيين النموذج)
     */
    public function getSystemSettingsData()
    {
        $settings = Setting::getAllSettings();

        return response()->json([
            'success' => true,
            'data'    => $settings
        ]);
    }
}