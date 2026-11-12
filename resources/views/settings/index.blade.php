<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات | نظام إدارة البقالة</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root {
          
            --success-color: #34c759;
            --warning-color: #ff9500;
            --danger-color: #ff3b30;
            --dark-color: #1c1c1e;
            --light-color: #f2f2f7;
          
            --border-radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
                     font-family: 'Tajawal', sans-serif;
            background-color: #f2f2f7;
            color: var(--dark-color);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .logout-item{
    width: 100%;
    border: none;
    background: transparent;
    text-align: right;
    cursor: pointer;
}

.logout-item:hover{
    background: rgba(255, 80, 80, 0.12);
}

.logout-item i{
    color: #ff6b6b;
}
        /* المحتوى الرئيسي */
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* شريط العنوان العلوي */
        .top-bar {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
        }

        .page-title p {
            color: #8e8e93;
            font-size: 15px;
            margin-top: 5px;
        }

        /* محتوى الإعدادات */
        .settings-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .settings-tabs {
            display: flex;
            background: white;
            border-radius: var(--border-radius);
            padding: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            flex-wrap: wrap;
            gap: 5px;
        }

        .settings-tab {
            flex: 1;
            min-width: 150px;
            padding: 15px 20px;
            background: none;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all var(--transition-speed) ease;
            color: #8e8e93;
            justify-content: center;
            font-family: 'Tajawal', sans-serif;
        }

        .settings-tab:hover {
            background: #f2f2f7;
            color: var(--dark-color);
        }

        .settings-tab.active {
            background: var(--primary-color);
            color: white;
        }

        .settings-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .settings-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .settings-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f2f2f7;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .section-header i {
            color: var(--primary-color);
            font-size: 22px;
        }

        /* نموذج الإعدادات */
        .settings-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
            font-family: 'Tajawal', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-control[readonly] {
            background: #fafafa;
            cursor: not-allowed;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #f2f2f7;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }

        .password-strength.weak .password-strength-meter {
            background: var(--danger-color);
            width: 33%;
        }

        .password-strength.medium .password-strength-meter {
            background: var(--warning-color);
            width: 66%;
        }

        .password-strength.strong .password-strength-meter {
            background: var(--success-color);
            width: 100%;
        }

        .password-hint {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #8e8e93;
        }

        /* معلومات الحساب */
        .account-info {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
            padding: 25px;
            background: #fafafa;
            border-radius: 16px;
        }

        .account-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .account-details h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .account-details p {
            color: #8e8e93;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* إعدادات النظام */
        .system-settings {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .setting-item {
            background: #fafafa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e5ea;
            transition: all var(--transition-speed) ease;
        }

        .setting-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .setting-item label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .setting-item p {
            font-size: 14px;
            color: #8e8e93;
            margin-top: 8px;
            line-height: 1.5;
        }

        /* زر الحفظ */
        .save-button {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-primary {
            padding: 12px 24px;
            border: none;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--transition-speed) ease;
            font-family: 'Tajawal', sans-serif;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        .btn-secondary {
            padding: 12px 24px;
            border: 1px solid #e5e5ea;
            background: white;
            border-radius: 12px;
            color: var(--dark-color);
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--transition-speed) ease;
            font-family: 'Tajawal', sans-serif;
        }

        .btn-secondary:hover {
            background: #f2f2f7;
            transform: translateY(-2px);
        }

        /* رسالة تنبيه */
        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 3000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .alert-message.show {
            display: flex;
            transform: translateX(0);
        }

        .alert-message.success {
            border-right: 4px solid var(--success-color);
        }

        .alert-message.warning {
            border-right: 4px solid var(--warning-color);
        }

        .alert-message.error {
            border-right: 4px solid var(--danger-color);
        }

        .alert-message i {
            font-size: 20px;
        }

        .alert-message.success i {
            color: var(--success-color);
        }

        .alert-message.warning i {
            color: var(--warning-color);
        }

        .alert-message.error i {
            color: var(--danger-color);
        }

        /* حالة الإدخال غير صالح */
        .form-control.is-invalid {
            border-color: var(--danger-color) !important;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 12px;
            margin-top: 5px;
            display: none;
            align-items: center;
            gap: 5px;
        }

        .error-message.show {
            display: flex;
        }

        /* تحميل */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* زر القائمة المتنقلة */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark-color);
            cursor: pointer;
            padding: 10px;
        }

        /* تصميم للجوّال */
        @media (max-width: 768px) {
          
            
            .mobile-menu-btn {
                display: block;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .settings-tabs {
                flex-direction: column;
            }
            
            .settings-tab {
                width: 100%;
            }
            
            .account-info {
                flex-direction: column;
                text-align: center;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .system-settings {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .save-button {
                flex-direction: column;
            }
            
            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }
            
            .settings-section {
                padding: 20px;
            }
        }

        /* تخصيص الـ select */
        select.form-control {
            cursor: pointer;
            background: white url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat left 0.75rem center;
            background-size: 16px 12px;
            padding-left: 2.5rem;
        }

        /* تخصيص textarea */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- الشريط الجانبي -->
   @include('partials.sidebar')
        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <!-- شريط العنوان العلوي -->
            <div class="top-bar">
                <div class="page-title">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1>الإعدادات</h1>
                        <p>إدارة حساب المدير وإعدادات النظام العامة</p>
                    </div>
                </div>
            </div>
            
            <!-- محتوى الإعدادات -->
            <div class="settings-container">
                <!-- علامات التبويب -->
                <div class="settings-tabs">
                    <button class="settings-tab active" onclick="switchSettingsTab('profile')">
                        <i class="fas fa-user"></i>
                        حساب المدير
                    </button>
                    <button class="settings-tab" onclick="switchSettingsTab('password')">
                        <i class="fas fa-key"></i>
                        كلمة المرور
                    </button>
                    <button class="settings-tab" onclick="switchSettingsTab('system')">
                        <i class="fas fa-cogs"></i>
                        إعدادات النظام
                    </button>
                </div>
                
                <!-- محتوى الإعدادات -->
                <div class="settings-content">
                    <!-- إعدادات حساب المدير -->
                    <div id="profile-settings" class="settings-section active">
                        <div class="section-header">
                            <i class="fas fa-user"></i>
                            <h2>إعدادات حساب المدير</h2>
                        </div>
                        
                        <div class="account-info">
                            <div class="account-avatar" id="userAvatar">{{ substr($user->name, 0, 1) }}</div>
                            <div class="account-details">
                                <h3 id="userFullName">{{ $user->name }}</h3>
                                <p><i class="fas fa-envelope"></i> <span id="userEmail">{{ $user->email }}</span></p>
                                <p><i class="fas fa-phone"></i> <span id="userPhone">{{ $user->phone ?? 'غير محدد' }}</span></p>
                                <p><i class="fas fa-user-tag"></i> <span>مدير النظام</span></p>
                            </div>
                        </div>
                        
                        <form class="settings-form" id="profileForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">
                                        <i class="fas fa-user"></i> الاسم الأول
                                    </label>
                                    <input type="text" 
                                           id="firstName" 
                                           name="first_name"
                                           class="form-control" 
                                           placeholder="أدخل الاسم الأول"
                                           value="{{ explode(' ', $user->name, 2)[0] ?? '' }}"
                                           required>
                                    <div class="error-message" id="firstNameError"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="lastName">
                                        <i class="fas fa-user"></i> اسم العائلة
                                    </label>
                                    <input type="text" 
                                           id="lastName" 
                                           name="last_name"
                                           class="form-control" 
                                           placeholder="أدخل اسم العائلة"
                                           value="{{ explode(' ', $user->name, 2)[1] ?? '' }}"
                                           required>
                                    <div class="error-message" id="lastNameError"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i> البريد الإلكتروني
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email"
                                       class="form-control" 
                                       placeholder="أدخل البريد الإلكتروني"
                                       value="{{ $user->email }}"
                                       required>
                                <div class="error-message" id="emailError"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i> رقم الهاتف
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone"
                                       class="form-control" 
                                       placeholder="أدخل رقم الهاتف"
                                       value="{{ $user->phone ?? '' }}"
                                       required>
                                <div class="error-message" id="phoneError"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="username">
                                    <i class="fas fa-user-circle"></i> اسم المستخدم
                                </label>
                                <input type="text" 
                                       id="username" 
                                       class="form-control" 
                                       value="{{ $user->email }}"
                                       readonly>
                                <small class="password-hint">اسم المستخدم هو البريد الإلكتروني ولا يمكن تغييره</small>
                            </div>
                            
                            <div class="save-button">
                                <button type="button" class="btn-secondary" onclick="resetProfileForm()">
                                    <i class="fas fa-undo"></i>
                                    إعادة تعيين
                                </button>
                                <button type="button" class="btn-primary" onclick="saveProfile()">
                                    <i class="fas fa-save"></i>
                                    حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- تغيير كلمة المرور -->
                    <div id="password-settings" class="settings-section">
                        <div class="section-header">
                            <i class="fas fa-key"></i>
                            <h2>تغيير كلمة المرور</h2>
                        </div>
                        
                        <form class="settings-form" id="passwordForm">
                            @csrf
                            
                            <div class="form-group">
                                <label for="currentPassword">
                                    <i class="fas fa-lock"></i> كلمة المرور الحالية
                                </label>
                                <input type="password"
                                       id="currentPassword"
                                       name="current_password"
                                       class="form-control"
                                       placeholder="أدخل كلمة المرور الحالية"
                                       required>
                                <div class="error-message" id="currentPasswordError"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="newPassword">
                                    <i class="fas fa-lock"></i> كلمة المرور الجديدة
                                </label>
                                <input type="password"
                                       id="newPassword"
                                       name="new_password"
                                       class="form-control"
                                       placeholder="أدخل كلمة المرور الجديدة"
                                       required
                                       minlength="8"
                                       oninput="checkPasswordStrength()">
                                <div class="password-strength" id="passwordStrength">
                                    <div class="password-strength-meter"></div>
                                </div>
                                <small class="password-hint">
                                    يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل، وتشمل حرفًا كبيرًا، وحرفًا صغيرًا، ورقمًا، ورمزًا خاصًا
                                </small>
                                <div class="error-message" id="newPasswordError"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirmPassword">
                                    <i class="fas fa-lock"></i> تأكيد كلمة المرور الجديدة
                                </label>
                                <input type="password"
                                       id="confirmPassword"
                                       name="new_password_confirmation"
                                       class="form-control"
                                       placeholder="أعد إدخال كلمة المرور الجديدة"
                                       required
                                       minlength="8">
                                <div class="error-message" id="confirmPasswordError"></div>
                            </div>
                            
                            <div class="form-group">
                                <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; color: #856404;">
                                    <h4 style="margin-bottom: 8px; color: #856404;">
                                        <i class="fas fa-shield-alt"></i> نصائح أمنية:
                                    </h4>
                                    <ul style="margin-right: 20px; font-size: 14px;">
                                        <li>لا تستخدم كلمات مرور تستخدمها في مواقع أخرى</li>
                                        <li>تجنب استخدام المعلومات الشخصية (الميلاد، الأسماء)</li>
                                        <li>غير كلمة المرور كل 3 أشهر على الأقل</li>
                                        <li>لا تشارك كلمة المرور مع أي شخص</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="save-button">
                                <button type="button" class="btn-secondary" onclick="resetPasswordForm()">
                                    <i class="fas fa-undo"></i>
                                    إعادة تعيين
                                </button>
                                <button type="button" class="btn-primary" onclick="changePassword()">
                                    <i class="fas fa-key"></i>
                                    تغيير كلمة المرور
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- إعدادات النظام -->
                    <div id="system-settings" class="settings-section">
                        <div class="section-header">
                            <i class="fas fa-cogs"></i>
                            <h2>إعدادات النظام العامة</h2>
                        </div>
                        
                        <form class="settings-form" id="systemForm">
                            @csrf
                            <div class="form-group">
                                <label for="storeName">
                                    <i class="fas fa-store"></i> اسم المتجر
                                </label>
                                <input type="text" 
                                       id="storeName" 
                                       name="store_name"
                                       class="form-control" 
                                       placeholder="أدخل اسم المتجر"
                                       value="{{ $systemSettings['store_name'] }}"
                                       required>
                                <p>يظهر هذا الاسم في الفواتير والتقارير</p>
                                <div class="error-message" id="storeNameError"></div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="storePhone">
                                        <i class="fas fa-phone"></i> رقم هاتف المتجر
                                    </label>
                                    <input type="tel" 
                                           id="storePhone" 
                                           name="store_phone"
                                           class="form-control" 
                                           placeholder="أدخل رقم الهاتف"
                                           value="{{ $systemSettings['store_phone'] }}">
                                    <div class="error-message" id="storePhoneError"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="storeEmail">
                                        <i class="fas fa-envelope"></i> البريد الإلكتروني
                                    </label>
                                    <input type="email" 
                                           id="storeEmail" 
                                           name="store_email"
                                           class="form-control" 
                                           placeholder="أدخل البريد الإلكتروني"
                                           value="{{ $systemSettings['store_email'] }}">
                                    <div class="error-message" id="storeEmailError"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="storeAddress">
                                    <i class="fas fa-map-marker-alt"></i> عنوان المتجر
                                </label>
                                <textarea id="storeAddress" 
                                          name="store_address"
                                          class="form-control" 
                                          rows="3"
                                          placeholder="أدخل العنوان الكامل للمتجر">{{ $systemSettings['store_address'] }}</textarea>
                                <p>يظهر العنوان في الفواتير والتواصل مع العملاء</p>
                                <div class="error-message" id="storeAddressError"></div>
                            </div>
                            
                            <div class="system-settings">
                                <div class="setting-item">
                                    <label for="currency">
                                        <i class="fas fa-money-bill-wave"></i> العملة المستخدمة
                                    </label>
                                    <select id="currency" name="currency" class="form-control">
                                        <option value="SAR" {{ $systemSettings['currency'] == 'SAR' ? 'selected' : '' }}>ريال سعودي (ر.س)</option>
                                        <option value="USD" {{ $systemSettings['currency'] == 'USD' ? 'selected' : '' }}>دولار أمريكي ($)</option>
                                        <option value="EUR" {{ $systemSettings['currency'] == 'EUR' ? 'selected' : '' }}>يورو (€)</option>
                                        <option value="EGP" {{ $systemSettings['currency'] == 'EGP' ? 'selected' : '' }}>جنيه مصري (ج.م)</option>
                                        <option value="AED" {{ $systemSettings['currency'] == 'AED' ? 'selected' : '' }}>درهم إماراتي (د.إ)</option>
                                    </select>
                                    <p>العملة المستخدمة في الفواتير والتقارير</p>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="dateFormat">
                                        <i class="fas fa-calendar"></i> تنسيق التاريخ
                                    </label>
                                    <select id="dateFormat" name="date_format" class="form-control">
                                        <option value="DD/MM/YYYY" {{ $systemSettings['date_format'] == 'DD/MM/YYYY' ? 'selected' : '' }}>يوم/شهر/سنة (31/12/2024)</option>
                                        <option value="MM/DD/YYYY" {{ $systemSettings['date_format'] == 'MM/DD/YYYY' ? 'selected' : '' }}>شهر/يوم/سنة (12/31/2024)</option>
                                        <option value="YYYY-MM-DD" {{ $systemSettings['date_format'] == 'YYYY-MM-DD' ? 'selected' : '' }}>سنة-شهر-يوم (2024-12-31)</option>
                                    </select>
                                    <p>التنسيق المستخدم لعرض التواريخ في النظام</p>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="timeFormat">
                                        <i class="fas fa-clock"></i> تنسيق الوقت
                                    </label>
                                    <select id="timeFormat" name="time_format" class="form-control">
                                        <option value="12h" {{ $systemSettings['time_format'] == '12h' ? 'selected' : '' }}>12 ساعة (08:30 م)</option>
                                        <option value="24h" {{ $systemSettings['time_format'] == '24h' ? 'selected' : '' }}>24 ساعة (20:30)</option>
                                    </select>
                                    <p>التنسيق المستخدم لعرض الأوقات في النظام</p>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="language">
                                        <i class="fas fa-language"></i> لغة النظام
                                    </label>
                                    <select id="language" name="language" class="form-control">
                                        <option value="ar" {{ $systemSettings['language'] == 'ar' ? 'selected' : '' }}>العربية</option>
                                        <option value="en" {{ $systemSettings['language'] == 'en' ? 'selected' : '' }}>الإنجليزية</option>
                                    </select>
                                    <p>لغة واجهة المستخدم للنظام</p>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="taxRate">
                                        <i class="fas fa-percentage"></i> نسبة الضريبة
                                    </label>
                                    <input type="number" 
                                           id="taxRate" 
                                           name="tax_rate"
                                           class="form-control" 
                                           placeholder="أدخل نسبة الضريبة"
                                           value="{{ $systemSettings['tax_rate'] }}"
                                           min="0"
                                           max="100"
                                           step="0.01">
                                    <p>نسبة الضريبة المطبقة على المبيعات (%)</p>
                                    <div class="error-message" id="taxRateError"></div>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="expiryWarningDays">
                                        <i class="fas fa-exclamation-triangle"></i> تحذير انتهاء الصلاحية
                                    </label>
                                    <input type="number" 
                                           id="expiryWarningDays" 
                                           name="expiry_warning_days"
                                           class="form-control" 
                                           placeholder="أدخل عدد الأيام"
                                           value="{{ $systemSettings['expiry_warning_days'] }}"
                                           min="1"
                                           max="365">
                                    <p>عدد الأيام للتحذير قبل انتهاء صلاحية المنتجات</p>
                                    <div class="error-message" id="expiryWarningDaysError"></div>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="lowStockThreshold">
                                        <i class="fas fa-exclamation-triangle"></i> حد المخزون المنخفض
                                    </label>
                                    <input type="number" 
                                           id="lowStockThreshold" 
                                           name="low_stock_threshold"
                                           class="form-control" 
                                           placeholder="أدخل الحد الأدنى"
                                           value="{{ $systemSettings['low_stock_threshold'] }}"
                                           min="1"
                                           max="1000">
                                    <p>الحد الأدنى للمخزون لإظهار تحذير المنتجات المنخفضة</p>
                                    <div class="error-message" id="lowStockThresholdError"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px; color: #155724;">
                                    <h4 style="margin-bottom: 8px; color: #155724;">
                                        <i class="fas fa-info-circle"></i> ملاحظة هامة:
                                    </h4>
                                    <p style="margin: 0; font-size: 14px;">
                                        إعدادات النظام لا تؤثر على البيانات السابقة، ولكنها تطبق على البيانات الجديدة والتقارير المستقبلية.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="save-button">
                                <button type="button" class="btn-secondary" onclick="resetSystemForm()">
                                    <i class="fas fa-undo"></i>
                                    إعادة تعيين
                                </button>
                                <button type="button" class="btn-primary" onclick="saveSystemSettings()">
                                    <i class="fas fa-save"></i>
                                    حفظ الإعدادات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- رسالة تنبيه -->
    <div id="alertMessage" class="alert-message">
        <i class="fas fa-check-circle"></i>
        <span id="alertText">تمت العملية بنجاح</span>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // الحصول على token CSRF من meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // تهيئة AJAX مع CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        // ========== دوال التنبيهات ==========
        function showAlert(message, type = 'success') {
            const alert = document.getElementById('alertMessage');
            const alertText = document.getElementById('alertText');
            const icon = alert.querySelector('i');
            
            alertText.textContent = message;
            alert.className = `alert-message ${type} show`;
            
            // تغيير الأيقونة حسب نوع الرسالة
            if (type === 'success') {
                icon.className = 'fas fa-check-circle';
            } else if (type === 'warning') {
                icon.className = 'fas fa-exclamation-triangle';
            } else {
                icon.className = 'fas fa-exclamation-circle';
            }
            
            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
        }
        
        // ========== تبديل التبويبات ==========
        function switchSettingsTab(tabName) {
            // تحديث علامات التبويب
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // إخفاء جميع الأقسام
            document.querySelectorAll('.settings-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // إظهار القسم المختار
            document.getElementById(`${tabName}-settings`).classList.add('active');
        }
        
        // ========== دوال معالجة الأخطاء ==========
        function clearFormErrors(formId) {
            const form = document.getElementById(formId);
            if (form) {
                form.querySelectorAll('.error-message').forEach(error => {
                    error.style.display = 'none';
                    error.textContent = '';
                });
                form.querySelectorAll('.form-control').forEach(input => {
                    input.classList.remove('is-invalid');
                });
            }
        }
        
        function showFormErrors(formId, errors) {
            clearFormErrors(formId);
            
            // خريطة تحويل أسماء الحقول من snake_case إلى IDs في الصفحة
            const fieldMap = {
                'current_password': 'currentPassword',
                'new_password': 'newPassword',
                'new_password_confirmation': 'confirmPassword',
                'first_name': 'firstName',
                'last_name': 'lastName',
                'email': 'email',
                'phone': 'phone',
                'store_name': 'storeName',
                'store_phone': 'storePhone',
                'store_email': 'storeEmail',
                'store_address': 'storeAddress',
                'tax_rate': 'taxRate',
                'expiry_warning_days': 'expiryWarningDays',
                'low_stock_threshold': 'lowStockThreshold'
            };
            
            Object.keys(errors).forEach(field => {
                const fieldId = fieldMap[field] || field;
                const errorElement = document.getElementById(`${fieldId}Error`);
                const inputElement = document.getElementById(fieldId);
                
                if (errorElement && inputElement) {
                    errorElement.textContent = errors[field][0];
                    errorElement.style.display = 'flex';
                    inputElement.classList.add('is-invalid');
                }
            });
        }
        
        // ========== دوال الحساب الشخصي ==========
        async function saveProfile() {
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);
            const saveButton = form.querySelector('.btn-primary');
            
            saveButton.classList.add('loading');
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
            
            try {
                const response = await fetch('{{ route("settings.profile.update") }}', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // تحديث العرض
                    const userAvatar = document.getElementById('userAvatar');
                    const userFullName = document.getElementById('userFullName');
                    const userEmail = document.getElementById('userEmail');
                    const userPhone = document.getElementById('userPhone');
                    
                    const firstName = document.getElementById('firstName').value;
                    const lastName = document.getElementById('lastName').value;
                    
                    userAvatar.textContent = (firstName[0] || 'م') + (lastName[0] || 'أ');
                    userFullName.textContent = `${firstName} ${lastName}`;
                    userEmail.textContent = document.getElementById('email').value;
                    userPhone.textContent = document.getElementById('phone').value;
                    
                    showAlert(data.message, 'success');
                    clearFormErrors('profileForm');
                } else {
                    showFormErrors('profileForm', data.errors || {});
                    showAlert('الرجاء تصحيح الأخطاء', 'error');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في الاتصال بالخادم', 'error');
            } finally {
                saveButton.classList.remove('loading');
                saveButton.innerHTML = '<i class="fas fa-save"></i> حفظ التغييرات';
            }
        }
        
        async function resetProfileForm() {
            try {
                const response = await fetch('{{ route("settings.profile.data") }}');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('firstName').value = data.data.first_name;
                    document.getElementById('lastName').value = data.data.last_name;
                    document.getElementById('email').value = data.data.email;
                    document.getElementById('phone').value = data.data.phone;
                    
                    clearFormErrors('profileForm');
                    showAlert('تم إعادة تعيين النموذج', 'info');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ أثناء إعادة تعيين النموذج', 'error');
            }
        }
        
        // ========== دوال كلمة المرور ==========
        function checkPasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const strengthMeter = document.getElementById('passwordStrength');
            
            strengthMeter.classList.remove('weak', 'medium', 'strong');
            
            if (!password) return;
            
            let strength = 0;
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            if (strength <= 3) {
                strengthMeter.classList.add('weak');
            } else if (strength <= 5) {
                strengthMeter.classList.add('medium');
            } else {
                strengthMeter.classList.add('strong');
            }
        }
        
        async function changePassword() {
            const form = document.getElementById('passwordForm');
            const formData = new FormData(form);
            const saveButton = form.querySelector('.btn-primary');
            
            // التحقق من تطابق كلمتي المرور على العميل أولاً
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'كلمتا المرور غير متطابقتين';
                document.getElementById('confirmPasswordError').style.display = 'flex';
                document.getElementById('confirmPassword').classList.add('is-invalid');
                return;
            }
            
            saveButton.classList.add('loading');
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التغيير...';
            
            try {
                const response = await fetch('{{ route("settings.password.change") }}', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    resetPasswordForm();
                    showAlert(data.message, 'success');
                } else {
                    showFormErrors('passwordForm', data.errors || {});
                    showAlert('الرجاء تصحيح الأخطاء', 'error');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في الاتصال بالخادم', 'error');
            } finally {
                saveButton.classList.remove('loading');
                saveButton.innerHTML = '<i class="fas fa-key"></i> تغيير كلمة المرور';
            }
        }
        
        function resetPasswordForm() {
            document.getElementById('passwordForm').reset();
            document.getElementById('passwordStrength').className = 'password-strength';
            clearFormErrors('passwordForm');
            showAlert('تم إعادة تعيين النموذج', 'info');
        }
        
        // ========== دوال إعدادات النظام ==========
        async function saveSystemSettings() {
            const form = document.getElementById('systemForm');
            const formData = new FormData(form);
            const saveButton = form.querySelector('.btn-primary');
            
            saveButton.classList.add('loading');
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
            
            try {
                const response = await fetch('{{ route("settings.system.save") }}', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(data.message, 'success');
                    clearFormErrors('systemForm');
                } else {
                    showFormErrors('systemForm', data.errors || {});
                    showAlert('الرجاء تصحيح الأخطاء', 'error');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في الاتصال بالخادم', 'error');
            } finally {
                saveButton.classList.remove('loading');
                saveButton.innerHTML = '<i class="fas fa-save"></i> حفظ الإعدادات';
            }
        }
        
        async function resetSystemForm() {
            try {
                const response = await fetch('{{ route("settings.system.data") }}');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('storeName').value = data.data.store_name || '';
                    document.getElementById('storePhone').value = data.data.store_phone || '';
                    document.getElementById('storeEmail').value = data.data.store_email || '';
                    document.getElementById('storeAddress').value = data.data.store_address || '';
                    document.getElementById('currency').value = data.data.currency || 'SAR';
                    document.getElementById('dateFormat').value = data.data.date_format || 'DD/MM/YYYY';
                    document.getElementById('timeFormat').value = data.data.time_format || '12h';
                    document.getElementById('language').value = data.data.language || 'ar';
                    document.getElementById('taxRate').value = data.data.tax_rate || 15;
                    document.getElementById('expiryWarningDays').value = data.data.expiry_warning_days || 30;
                    document.getElementById('lowStockThreshold').value = data.data.low_stock_threshold || 10;
                    
                    clearFormErrors('systemForm');
                    showAlert('تم إعادة تعيين النموذج', 'info');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ أثناء إعادة تعيين النموذج', 'error');
            }
        }
        
        // ========== دوال الشريط الجانبي ==========
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                (!mobileMenuBtn || !mobileMenuBtn.contains(event.target)) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
        
        // ========== تهيئة الصفحة ==========
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                });
            });
        });
    </script>
</body>
</html>