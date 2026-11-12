<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap');

        :root {
            --primary-color: #0066ff;
            --success-color: #34c759;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 74%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow-x: hidden;
            padding: 20px;
        }

        .signup-container {
            width: 100%;
            max-width: 480px;
        }

        .signup-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 40px 35px;
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo i {
            font-size: 48px;
            color: #fff;
            opacity: 0.9;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 600;
            margin-top: 15px;
            letter-spacing: 0.5px;
        }

        .welcome-text {
            margin-bottom: 35px;
        }

        .welcome-text h2 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .welcome-text p {
            font-size: 16px;
            opacity: 0.8;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: right;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            opacity: 0.7;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px 16px 50px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            color: #fff;
            font-size: 16px;
            font-family: inherit;
            transition: all var(--transition-speed) ease;
            backdrop-filter: blur(10px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 0 0 2px rgba(0, 102, 255, 0.2);
        }

        .form-control.error {
            border-color: #ff3b30;
        }

        .form-control.success {
            border-color: var(--success-color);
        }

        .error-message {
            color: #ff3b30;
            font-size: 14px;
            margin-top: 8px;
            text-align: right;
            display: none;
        }

        .password-requirements {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 15px;
            margin: 15px 0;
            text-align: right;
        }

        .password-requirements h4 {
            font-size: 14px;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.9);
        }

        .requirement {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        .requirement i {
            font-size: 12px;
        }

        .requirement.met {
            color: var(--success-color);
        }

        .requirement.met i {
            color: var(--success-color);
        }

        .btn-signup {
            width: 100%;
            padding: 16px;
            background: var(--success-color);
            border: none;
            border-radius: 16px;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            margin-top: 20px;
            backdrop-filter: blur(10px);
        }

        .btn-signup:hover {
            background: #2db54d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 199, 89, 0.3);
        }

        .btn-signup:disabled {
            background: rgba(255, 255, 255, 0.2);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .divider {
            margin: 30px 0;
            position: relative;
            text-align: center;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .divider span {
            background: rgba(255, 255, 255, 0.08);
            padding: 0 15px;
            font-size: 14px;
            opacity: 0.7;
        }

        .social-signup {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .login-link {
            margin-top: 25px;
            font-size: 14px;
            opacity: 0.8;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-right: 5px;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .terms {
            margin-top: 20px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
        }

        .terms a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .form-control, .btn-signup, .social-btn {
            position: relative;
            overflow: hidden;
        }

        .form-control::after, .btn-signup::after, .social-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0);
            transition: box-shadow 0.3s ease;
        }

        .form-control:focus::after, .btn-signup:hover::after, .social-btn:hover::after {
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 10px;
            }
            
            .signup-card {
                padding: 30px 25px;
            }
            
            .social-signup {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <div class="logo">
                <i class="fas fa-store"></i>
                <h1>إنشاء حساب جديد</h1>
            </div>
            
            <div class="welcome-text">
                <h2>مرحباً بك في نظامنا</h2>
                <p>أنشئ حسابك كمدير للنظام لتبدأ إدارة متجرك</p>
            </div>
         <form id="signupForm" method="POST" action="{{ route('register') }}">
        @csrf
                <!-- الاسم الكامل -->
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
<input type="text" class="form-control" name="name" id="fullName" placeholder="الاسم الكامل" required>
                    </div>
                    <div class="error-message" id="fullNameError">الرجاء إدخال الاسم الكامل</div>
                </div>

                <!-- البريد الإلكتروني -->
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" id="email" name="email" placeholder="البريد الإلكتروني" required>
                    </div>
                    <div class="error-message" id="emailError">الرجاء إدخال بريد إلكتروني صحيح</div>
                </div>

                <!-- كلمة المرور -->
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
<input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور" required>
                    </div>
                    <div class="error-message" id="passwordError">كلمة المرور غير صحيحة</div>
                    
                    <div class="password-requirements">
                        <h4>متطلبات كلمة المرور:</h4>
                        <div class="requirement" id="reqLength">
                            <span>8 أحرف على الأقل</span>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="requirement" id="reqUppercase">
                            <span>حرف كبير على الأقل</span>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="requirement" id="reqNumber">
                            <span>رقم واحد على الأقل</span>
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>

                <!-- تأكيد كلمة المرور -->
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
<input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="تأكيد كلمة المرور" required>
                    </div>
                    <div class="error-message" id="confirmPasswordError">كلمتا المرور غير متطابقتين</div>
                </div>

                <button type="submit" class="btn-signup" id="signupBtn" disabled>
                    <i class="fas fa-user-plus"></i> إنشاء الحساب
                </button>
            </form>

            <div class="divider">
                <span>أو سجل عبر</span>
            </div>

            <div class="social-signup">
                <button type="button" class="social-btn" onclick="signupWithGoogle()">
                    <i class="fab fa-google"></i>
                    Google
                </button>
                <button type="button" class="social-btn" onclick="signupWithFacebook()">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </button>
            </div>

            <div class="login-link">
                لديك حساب بالفعل؟ <a href="{{ route('login') }}">سجل الدخول هنا</a>
            </div>

            <div class="terms">
                بالنقر على "إنشاء الحساب"، فإنك توافق على <a href="#">شروط الخدمة</a> و <a href="#">سياسة الخصوصية</a> الخاصة بنا.
            </div>
        </div>
    </div>

    <script>
        // عناصر DOM
        const fullNameInput = document.getElementById('fullName');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const signupBtn = document.getElementById('signupBtn');
        const signupForm = document.getElementById('signupForm');

        // متطلبات كلمة المرور
        const reqLength = document.getElementById('reqLength');
        const reqUppercase = document.getElementById('reqUppercase');
        const reqNumber = document.getElementById('reqNumber');

        // متغيرات للتحقق من المتطلبات
        let isLengthValid = false;
        let isUppercaseValid = false;
        let isNumberValid = false;
        let isPasswordsMatch = false;

        // التحقق من صحة الاسم الكامل
        function validateFullName() {
            const fullName = fullNameInput.value.trim();
            const errorElement = document.getElementById('fullNameError');
            
            if (fullName.length < 2) {
                fullNameInput.classList.add('error');
                fullNameInput.classList.remove('success');
                errorElement.style.display = 'block';
                return false;
            } else {
                fullNameInput.classList.remove('error');
                fullNameInput.classList.add('success');
                errorElement.style.display = 'none';
                return true;
            }
        }

        // التحقق من صحة البريد الإلكتروني
        function validateEmail() {
            const email = emailInput.value.trim();
            const errorElement = document.getElementById('emailError');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(email)) {
                emailInput.classList.add('error');
                emailInput.classList.remove('success');
                errorElement.style.display = 'block';
                return false;
            } else {
                emailInput.classList.remove('error');
                emailInput.classList.add('success');
                errorElement.style.display = 'none';
                return true;
            }
        }

        // التحقق من متطلبات كلمة المرور
        function validatePassword() {
            const password = passwordInput.value;
            const errorElement = document.getElementById('passwordError');
            
            // التحقق من الطول
            isLengthValid = password.length >= 8;
            reqLength.classList.toggle('met', isLengthValid);
            reqLength.querySelector('i').className = isLengthValid ? 'fas fa-check' : 'fas fa-times';
            
            // التحقق من الحرف الكبير
            isUppercaseValid = /[A-Z]/.test(password);
            reqUppercase.classList.toggle('met', isUppercaseValid);
            reqUppercase.querySelector('i').className = isUppercaseValid ? 'fas fa-check' : 'fas fa-times';
            
            // التحقق من الرقم
            isNumberValid = /\d/.test(password);
            reqNumber.classList.toggle('met', isNumberValid);
            reqNumber.querySelector('i').className = isNumberValid ? 'fas fa-check' : 'fas fa-times';
            
            const isValid = isLengthValid && isUppercaseValid && isNumberValid;
            
            if (!isValid && password.length > 0) {
                passwordInput.classList.add('error');
                passwordInput.classList.remove('success');
                errorElement.style.display = 'block';
            } else if (password.length > 0) {
                passwordInput.classList.remove('error');
                passwordInput.classList.add('success');
                errorElement.style.display = 'none';
            } else {
                passwordInput.classList.remove('error', 'success');
                errorElement.style.display = 'none';
            }
            
            return isValid;
        }

        // التحقق من تطابق كلمتي المرور
        function validateConfirmPassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const errorElement = document.getElementById('confirmPasswordError');
            
            isPasswordsMatch = password === confirmPassword && password.length > 0;
            
            if (!isPasswordsMatch && confirmPassword.length > 0) {
                confirmPasswordInput.classList.add('error');
                confirmPasswordInput.classList.remove('success');
                errorElement.style.display = 'block';
                return false;
            } else if (confirmPassword.length > 0) {
                confirmPasswordInput.classList.remove('error');
                confirmPasswordInput.classList.add('success');
                errorElement.style.display = 'none';
                return true;
            } else {
                confirmPasswordInput.classList.remove('error', 'success');
                errorElement.style.display = 'none';
                return false;
            }
        }

        // التحقق من النموذج بأكمله
        function validateForm() {
            const isFullNameValid = validateFullName();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            const isConfirmPasswordValid = validateConfirmPassword();
            
            // تفعيل/تعطيل زر الإنشاء
            if (isFullNameValid && isEmailValid && isPasswordValid && isPasswordsMatch) {
                signupBtn.disabled = false;
            } else {
                signupBtn.disabled = true;
            }
        }

        // إضافة مستمعي الأحداث
        fullNameInput.addEventListener('input', validateForm);
        emailInput.addEventListener('input', validateForm);
        passwordInput.addEventListener('input', function() {
            validatePassword();
            validateConfirmPassword();
            validateForm();
        });
        confirmPasswordInput.addEventListener('input', function() {
            validateConfirmPassword();
            validateForm();
        });

        // معالجة تقديم النموذج
      signupForm.addEventListener('submit', function(e) {
    if (!validateFullName() || !validateEmail() || !validatePassword() || !isPasswordsMatch) {
        e.preventDefault();
    }
});
        // وظائف التسجيل الاجتماعي
        function signupWithGoogle() {
            alert('سيتم توجيهك إلى صفحة تسجيل الدخول بـ Google');
            // هنا سيتم تنفيذ OAuth 2.0 لـ Google
        }

        function signupWithFacebook() {
            alert('سيتم توجيهك إلى صفحة تسجيل الدخول بـ Facebook');
            // هنا سيتم تنفيذ Facebook Login
        }

        // التحقق الأولي للنموذج
        validateForm();
    </script>
</body>
</html>