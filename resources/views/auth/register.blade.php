<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #7209b7;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --light-text: #6c757d;
            --success-color: #4bb543;
            --error-color: #e63946;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }

        .illustration {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
            text-align: center;
        }

        .illustration h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .illustration p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .illustration-img {
            max-width: 80%;
            height: auto;
        }

        .form-container {
            flex: 1;
            padding: 50px 40px;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text);
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h1 {
            font-size: 2rem;
            color: var(--dark-text);
            margin-bottom: 10px;
        }

        .form-header p {
            color: var(--light-text);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-text);
            transition: var(--transition);
        }

        .input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
            background-color: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .form-input.success {
            border-color: var(--success-color);
        }

        .form-input.error {
            border-color: var(--error-color);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
        }

        .password-toggle {
            cursor: pointer;
            color: var(--light-text);
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
        }

        .error-icon {
            margin-right: 5px;
        }

        .strength-meter {
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-meter-fill {
            height: 100%;
            width: 0;
            border-radius: 2px;
            transition: var(--transition);
        }

        .strength-weak {
            background-color: var(--error-color);
            width: 33%;
        }

        .strength-medium {
            background-color: #ffa500;
            width: 66%;
        }

        .strength-strong {
            background-color: var(--success-color);
            width: 100%;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .login-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .login-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .submit-btn {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .social-signup {
            margin-top: 30px;
            text-align: center;
        }

        .social-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .social-divider::before,
        .social-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #e9ecef;
        }

        .social-divider span {
            padding: 0 15px;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .social-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            background: white;
            color: var(--dark-text);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .social-btn:hover {
            border-color: var(--primary-color);
            background-color: #f8f9fa;
        }

        .social-icon {
            margin-right: 8px;
            font-weight: bold;
        }

        .google {
            color: #DB4437;
        }

        .facebook {
            color: #4267B2;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .illustration {
                padding: 30px 20px;
            }

            .form-container {
                padding: 30px 25px;
            }

            .social-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="illustration">
        <h2>Join Our Community</h2>
        <p>Create an account to unlock exclusive features and personalized content</p>
        <svg class="illustration-img" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M200,50 C250,50 300,80 300,130 C300,180 250,210 200,210 C150,210 100,180 100,130 C100,80 150,50 200,50 Z" opacity="0.2"/>
            <path fill="#ffffff" d="M200,60 C245,60 285,85 285,125 C285,165 245,190 200,190 C155,190 115,165 115,125 C115,85 155,60 200,60 Z" opacity="0.3"/>
            <path fill="#ffffff" d="M200,70 C240,70 270,90 270,120 C270,150 240,170 200,170 C160,170 130,150 130,120 C130,90 160,70 200,70 Z" opacity="0.4"/>
            <circle cx="200" cy="120" r="40" fill="#ffffff" opacity="0.6"/>
            <path fill="#ffffff" d="M170,250 L230,250 L230,280 C230,295 218,307 203,307 C188,307 176,295 176,280 L170,250 Z" opacity="0.7"/>
            <circle cx="185" cy="110" r="5" fill="#4cc9f0"/>
            <circle cx="215" cy="110" r="5" fill="#4cc9f0"/>
            <path fill="#ffffff" d="M190,130 L210,130 C212,130 214,132 214,134 C214,138 210,142 205,142 C200,142 196,138 196,134 C196,132 188,130 190,130 Z" opacity="0.8"/>
        </svg>
    </div>

    <div class="form-container">
        <div class="logo">
            <div class="logo-icon">TA</div>
            <div class="logo-text">Travel Advisor</div>
        </div>

        <div class="form-header">
            <h1>Create Account</h1>
            <p>Join thousands of users who trust our platform</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="signupForm">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <div class="input-container">
                    <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name">
                    <div class="input-icon">👤</div>
                </div>
                <div class="error-message" id="name-error">
                    <span id="name-error-text"></span>
                </div>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-container">
                    <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email">
                    <div class="input-icon">✉</div>
                </div>
                <div class="error-message" id="email-error">
                    <span id="email-error-text"></span>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-container">
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password">
                    <div class="input-icon password-toggle" id="password-toggle">👁</div>
                </div>
                <div class="strength-meter">
                    <div class="strength-meter-fill" id="password-strength"></div>
                </div>
                <div class="error-message" id="password-error">
                    <span id="password-error-text"></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="input-container">
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                    <div class="input-icon password-toggle" id="confirm-password-toggle">👁</div>
                </div>
                <div class="error-message" id="password-confirm-error">
                    <span id="password-confirm-error-text"></span>
                </div>
            </div>

            <div class="form-footer">
                <a class="login-link" href="{{ route('login') }}">
                    Already have an account?
                </a>
                <button type="submit" class="submit-btn">
                    Create Account
                </button>
            </div>
        </form>

        <div class="social-signup">
            <div class="social-divider">
                <span>Or sign up with</span>
            </div>
            <div class="social-buttons">
                <button type="button" class="social-btn google">
                    <span class="social-icon google">G</span> Google
                </button>
                <button type="button" class="social-btn facebook">
                    <span class="social-icon facebook">f</span> Facebook
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle
        const passwordToggle = document.getElementById('password-toggle');
        const confirmPasswordToggle = document.getElementById('confirm-password-toggle');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        passwordToggle.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.textContent = '🔒';
            } else {
                passwordInput.type = 'password';
                passwordToggle.textContent = '👁';
            }
        });

        confirmPasswordToggle.addEventListener('click', function() {
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                confirmPasswordToggle.textContent = '🔒';
            } else {
                confirmPasswordInput.type = 'password';
                confirmPasswordToggle.textContent = '👁';
            }
        });

        // Password strength indicator
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const strengthMeter = document.getElementById('password-strength');

            // Reset classes
            strengthMeter.className = 'strength-meter-fill';

            if (password.length === 0) {
                strengthMeter.style.width = '0';
                return;
            }

            // Calculate strength (simplified)
            let strength = 0;

            // Length check
            if (password.length >= 8) strength += 1;

            // Contains lowercase
            if (/[a-z]/.test(password)) strength += 1;

            // Contains uppercase
            if (/[A-Z]/.test(password)) strength += 1;

            // Contains numbers
            if (/[0-9]/.test(password)) strength += 1;

            // Contains special characters
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            // Update strength meter
            if (strength <= 2) {
                strengthMeter.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthMeter.classList.add('strength-medium');
            } else {
                strengthMeter.classList.add('strength-strong');
            }
        });

        // Form validation
        const form = document.getElementById('signupForm');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        // Error elements
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const passwordError = document.getElementById('password-error');
        const passwordConfirmError = document.getElementById('password-confirm-error');

        // Initially hide all error messages
        nameError.style.display = 'none';
        emailError.style.display = 'none';
        passwordError.style.display = 'none';
        passwordConfirmError.style.display = 'none';

        // Real-time validation
        nameInput.addEventListener('blur', validateName);
        emailInput.addEventListener('blur', validateEmail);
        passwordInput.addEventListener('blur', validatePassword);
        confirmPasswordInput.addEventListener('blur', validateConfirmPassword);

        function validateName() {
            const name = nameInput.value.trim();
            if (name.length < 2) {
                showError(nameInput, nameError, 'Name must be at least 2 characters long');
                return false;
            } else {
                hideError(nameInput, nameError);
                return true;
            }
        }

        function validateEmail() {
            const email = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                showError(emailInput, emailError, 'Please enter a valid email address');
                return false;
            } else {
                hideError(emailInput, emailError);
                return true;
            }
        }

        function validatePassword() {
            const password = passwordInput.value;

            if (password.length < 8) {
                showError(passwordInput, passwordError, 'Password must be at least 8 characters long');
                return false;
            } else {
                hideError(passwordInput, passwordError);
                return true;
            }
        }

        function validateConfirmPassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword) {
                showError(confirmPasswordInput, passwordConfirmError, 'Passwords do not match');
                return false;
            } else {
                hideError(confirmPasswordInput, passwordConfirmError);
                return true;
            }
        }

        function showError(input, errorElement, message) {
            input.classList.add('error');
            input.classList.remove('success');
            errorElement.style.display = 'flex';
            errorElement.querySelector('span:last-child').textContent = message;
        }

        function hideError(input, errorElement) {
            input.classList.remove('error');
            input.classList.add('success');
            errorElement.style.display = 'none';
        }

        // Form submission
        form.addEventListener('submit', function(e) {
            // Validate all fields
            const isNameValid = validateName();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            const isConfirmPasswordValid = validateConfirmPassword();

            if (!isNameValid || !isEmailValid || !isPasswordValid || !isConfirmPasswordValid) {
                e.preventDefault();
                // Focus on first invalid field
                if (!isNameValid) nameInput.focus();
                else if (!isEmailValid) emailInput.focus();
                else if (!isPasswordValid) passwordInput.focus();
                else confirmPasswordInput.focus();
            }
        });

        // Social signup buttons (placeholder functionality)
        document.querySelector('.social-btn.google').addEventListener('click', function() {
            alert('Google signup would be implemented here');
        });

        document.querySelector('.social-btn.facebook').addEventListener('click', function() {
            alert('Facebook signup would be implemented here');
        });
    });
</script>
</body>
</html>
