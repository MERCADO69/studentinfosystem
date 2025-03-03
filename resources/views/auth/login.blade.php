<x-guest-layout>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 48px;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .login-title {
            font-size: 32px;
            text-align: center;
            margin-bottom: 36px;
            color: #1e293b;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .input-label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            color: #475569;
            font-size: 15px;
        }

        .remember-me-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .form-checkbox {
            border-radius: 6px;
            width: 18px;
            height: 18px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
        }

        .form-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .login-button {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin: 24px 0;
            transition: all 0.2s ease;
        }

        .login-button:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .login-links {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .forgot-link:hover {
            color: #3b82f6;
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-group {
            margin-bottom: 24px;
        }
    </style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-container">
        <h1 class="login-title">Student Info System</h1>

        @if (request()->is('student/*'))
            <form method="POST" action="{{ route('student.login') }}">
                <input type="hidden" name="guard" value="student"> <!-- Add this line -->
        @else
            <form method="POST" action="{{ route('login') }}">
                <input type="hidden" name="guard" value="web"> <!-- Add this line -->
        @endif
                @csrf
                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" class="input-label" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required
                        autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" class="input-label" />
                    <x-text-input id="password" class="form-input" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <label for="remember_me" class="remember-me-label">
                        <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                        <span class="ms-2">{{ __('Keep me logged in') }}</span>
                    </label>
                </div>

                <button type="submit" class="login-button">
                    {{ __('Sign In') }}
                </button>

                <div class="login-links">
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </form>
    </div>
</x-guest-layout>