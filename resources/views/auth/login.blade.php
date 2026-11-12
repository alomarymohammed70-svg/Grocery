<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap');

        :root {
            --primary-color: #0066ff;
            --error-color: #ff3b30;
            --success-color: #34c759;
            --warning-color: #ffcc00;
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
            overflow: hidden;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
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

        /* أنماط التنبيهات */
        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: right;
            animation: slideIn 0.5s ease;
        }

        .alert-danger {
            background: rgba(255, 59, 48, 0.1);
            border: 1px solid rgba(255, 59, 48, 0.3);
            color: #ffcc00;
        }

        .alert-success {
            background: rgba(52, 199, 89, 0.1);
            border: 1px solid rgba(52, 199, 89, 0.3);
            color: #34c759;
        }

        .alert ul {
            list-style: none;
            padding-right: 0;
        }

        .alert li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert i {
            font-size: 14px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            border-color: var(--error-color);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--primary-color);
            border: none;
            border-radius: 16px;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            margin-top: 10px;
            backdrop-filter: blur(10px);
        }

        .btn-login:hover {
            background: #0052cc;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        .additional-options {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-password {
            color: #fff;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity var(--transition-speed) ease;
        }

        .forgot-password:hover {
            opacity: 1;
            text-decoration: underline;
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

        .social-login {
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

        .social-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .signup-link {
            margin-top: 25px;
            font-size: 14px;
            opacity: 0.8;
        }

        .signup-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-right: 5px;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Apple-style liquid effects */
        .form-control, .btn-login, .social-btn {
            position: relative;
            overflow: hidden;
        }

        .form-control::after, .btn-login::after, .social-btn::after {
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

        .form-control:focus::after, .btn-login:hover::after, .social-btn:hover::after {
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 10px;
            }
            
            .login-card {
                padding: 30px 25px;
            }
            
            .additional-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .social-login {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <i class="fas fa-store"></i>
                <h1>نظام إدارة البقالة</h1>
            </div>
            
            <div class="welcome-text">
                <h2>مرحباً بعودتك</h2>
                <p>سجل الدخول للمتابعة إلى نظام إدارة بقالتك</p>
            </div>

            <!-- عرض أخطاء التحقق من الصحة -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- عرض رسالة النجاح -->
            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               class="form-control {{ $errors->has('email') ? 'error' : '' }}" 
                               id="email" 
                               name="email" 
                               placeholder="البريد الإلكتروني" 
                               value="{{ old('email') }}" 
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control {{ $errors->has('password') ? 'error' : '' }}" 
                               id="password" 
                               name="password" 
                               placeholder="كلمة المرور" 
                               required>
                    </div>
                </div>

                <div class="additional-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                        تذكرني
                    </label>
    <a href="#" class="forgot-password" onclick="alert('ميزة استعادة كلمة المرور غير متاحة حالياً')">نسيت كلمة المرور؟</a>              </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                </button>
            </form>

            <div class="divider">
                <span>ميزات قادمة</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn disabled" title="قيد التطوير - سيتم تفعيل قريباً">
                    <i class="fab fa-google"></i>
                    Google
                </button>
                <button type="button" class="social-btn disabled" title="قيد التطوير - سيتم تفعيل قريباً">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </button>
            </div>

            <div class="signup-link">
                لا تمتلك حساباً؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a>
            </div>
        </div>
    </div>

    <script>
        // التحقق من صحة النموذج قبل الإرسال
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            let isValid = true;
            
            // التحقق من البريد الإلكتروني
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email').classList.add('error');
                isValid = false;
            } else {
                document.getElementById('email').classList.remove('error');
            }
            
            // التحقق من كلمة المرور
            if (password.length < 6) {
                document.getElementById('password').classList.add('error');
                isValid = false;
            } else {
                document.getElementById('password').classList.remove('error');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('الرجاء ملء جميع الحقول بشكل صحيح');
            }
        });

        // إزالة حالة الخطأ عند الكتابة
        document.getElementById('email').addEventListener('input', function() {
            this.classList.remove('error');
        });
        
        document.getElementById('password').addEventListener('input', function() {
            this.classList.remove('error');
        });
    </script>
</body>
</html>