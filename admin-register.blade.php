<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Santa Fe Water Billing System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #5624d0;
            --primary-dark: #401ea0;
            --text: #2b2d42;
            --text-light: #8d99ae;
            --light: #edf2f4;
            --white: #ffffff;
            --error: #ef233c;
            --success: #06d6a0;
            --border: #e0e0e0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            background: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .register-page {
            display: flex;
            background: var(--white);
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            max-width: 960px;
        }
        .register-illustration {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column; 
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center; 
        }
        .register-illustration img {
            max-width: 100%;
            height: auto;
        }
        .register-illustration h1 {
            font-size: 40px;
            color: black;
            font-weight: bold;
        }
        h2 {
            font-size: 30px;
        }
        .register-container {
            flex: 1;
            padding: 40px;
        }
        .register-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text);
        }
        .register-header p {
            font-size: 14px;
            color: var(--text-light);
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            background-color: var(--light);
            transition: all 0.3s ease;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(86, 36, 208, 0.1);
        }
        .form-group input.error,
        .form-group select.error {
            border-color: var(--error);
        }
        .error-message {
            color: var(--error);
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        .btn-register {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            border: none;
            color: #fff;
            font-weight: 500;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background: var(--primary-dark);
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        .login-link a {
            color: var(--primary);
            text-decoration: none;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 35, 60, 0.2);
        }
        @media (max-width: 768px) {
            .register-page {
                flex-direction: column;
            }
            .register-illustration {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="register-page">
        <div class="register-illustration">
            <img src="{{ asset('image/santafe.png') }}" alt="Register Illustration">
            <h1>Santa Fe Water</h1>
            <h2>Billing System</h2>
        </div>
        <div class="register-container">
            <div class="register-header">
                <h1>Sign up with email</h1>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form id="registerForm" method="POST" action="{{ route('admin-register') }}">
                @csrf

                <div class="form-group">
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required class="{{ $errors->has('first_name') ? 'error' : '' }}">
                    @error('first_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle Name (Optional)" class="{{ $errors->has('middle_name') ? 'error' : '' }}">
                    @error('middle_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required class="{{ $errors->has('last_name') ? 'error' : '' }}">
                    @error('last_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="date" name="birthdate" value="{{ old('birthdate') }}" required class="{{ $errors->has('birthdate') ? 'error' : '' }}">
                    @error('birthdate')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <select name="gender" required class="{{ $errors->has('gender') ? 'error' : '' }}">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <select name="role" required class="{{ $errors->has('role') ? 'error' : '' }}">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="accountant" {{ old('role') == 'accountant' ? 'selected' : '' }}>Accountant</option>
                        <option value="plumber" {{ old('role') == 'plumber' ? 'selected' : '' }}>Plumber</option>
                        <option value="consumers" {{ old('role') == 'consumers' ? 'selected' : '' }}>Consumer</option>
                    </select>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required class="{{ $errors->has('email') ? 'error' : '' }}">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="tel" name="contact_number" value="{{ old('contact_number') }}" placeholder="09123456789" required class="{{ $errors->has('contact_number') ? 'error' : '' }}">
                    @error('contact_number')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required class="{{ $errors->has('password') ? 'error' : '' }}">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn-register">Create Account</button>
                <div class="login-link">
                    Already have an account? <a href="{{ route('admin-login') }}">Log in</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on first error field if any
            const firstErrorField = document.querySelector('.error');
            if (firstErrorField) {
                firstErrorField.focus();
            }
        });
    </script>
</body>
</html>