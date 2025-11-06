<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Basmago</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
            --border-radius: 12px;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-logo {
            margin: 3% !important;
            padding: 3% !important;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            min-height: 600px;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -50px;
            left: -50px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            bottom: -50px;
            right: -50px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .brand-logo i {
            font-size: 28px;
            margin-right: 10px;
        }

        .brand-logo h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .welcome-text h2 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .welcome-text p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .features {
            margin-top: 40px;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .feature i {
            font-size: 18px;
            margin-right: 15px;
            background: rgba(255, 255, 255, 0.2);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature p {
            font-size: 14px;
        }

        .login-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .login-header p {
            color: var(--gray);
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 14px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #e1e5ee;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background-color: #f9fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            background-color: white;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 16px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            margin-right: 8px;
            accent-color: var(--primary);
        }

        .checkbox-container label {
            font-size: 14px;
            color: var(--gray);
        }

        .forgot-password {
            font-size: 14px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login i {
            margin-left: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
            color: var(--gray);
            font-size: 14px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5ee;
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fa;
            border: 1px solid #e1e5ee;
            color: var(--gray);
            font-size: 18px;
            transition: var(--transition);
            cursor: pointer;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .social-btn.google:hover {
            color: #DB4437;
            border-color: #DB4437;
        }

        .social-btn.facebook:hover {
            color: #4267B2;
            border-color: #4267B2;
        }

        .social-btn.twitter:hover {
            color: #1DA1F2;
            border-color: #1DA1F2;
        }

        .signup-link {
            text-align: center;
            font-size: 14px;
            color: var(--gray);
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .session-status {
            background: #e7f7ef;
            color: #0f9d58;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #0f9d58;
        }

        .input-error {
            color: #e53935;
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }

        .input-error i {
            margin-right: 5px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }

            .login-left {
                padding: 30px;
            }

            .login-right {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <!-- Left Side: Branding & Info -->
    <div class="login-left">
        <div className="flex justify-center items-center" style="padding-left: 5% !important;">
            <img
                src="/images/logo.jpeg"
                alt="Logo"
                className="h-16 w-16 object-contain login-logo"
            />
        </div>
        <div class="welcome-text">
            <p>Sign in to access your personalized dashboard, manage your account, and explore all the features we offer for our valued users.</p>
        </div>
        <div class="features">
            <div class="feature">
                <i class="fas fa-shield-alt"></i>
                <p>Enterprise-grade security</p>
            </div>
            <div class="feature">
                <i class="fas fa-bolt"></i>
                <p>Lightning fast performance</p>
            </div>
            <div class="feature">
                <i class="fas fa-headset"></i>
                <p>24/7 Customer support</p>
            </div>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="login-right">

        <div class="login-header">
            <h2>Sign In to Your Account</h2>
            <p>Enter your credentials to access your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input id="email" class="form-control" type="email" name="email" required autofocus autocomplete="username" placeholder="Enter your email">
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-options">
                <div class="checkbox-container">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot your password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                Log In <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="divider">
            <span>Or continue with</span>
        </div>

        <!-- Social Login -->
        <div class="social-login">
            <div class="social-btn google">
                <i class="fab fa-google"></i>
            </div>
            <div class="social-btn facebook">
                <i class="fab fa-facebook-f"></i>
            </div>
            <div class="social-btn twitter">
                <i class="fab fa-twitter"></i>
            </div>
        </div>

        <!-- Sign Up Link -->
        <div class="signup-link">
            Don't have an account? <a href="/register">Sign up now</a>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Add focus effects to form inputs
    const formControls = document.querySelectorAll('.form-control');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.parentElement.classList.add('focused');
        });

        control.addEventListener('blur', function() {
            if (this.value === '') {
                this.parentElement.parentElement.classList.remove('focused');
            }
        });
    });
</script>
</body>
</html>
