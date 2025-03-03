<x-guest-layout>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .reset-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 48px;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .reset-container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .reset-title {
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

        .reset-button {
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

        .reset-button:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .reset-links {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-login {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .back-to-login:hover {
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

    <div class="reset-container">
        <h1 class="reset-title">Reset Password</h1>

        <p class="text-center text-gray-600 mb-6">
            {{ __('Forgot your password? Enter your email and we will send you a reset link.') }}
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" class="input-label" />
                <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required
                    autofocus placeholder="your@email.com" />
                <x-input-error :messages="$errors->get('email')" class="error-message" />
            </div>

            <button type="submit" class="reset-button">
                {{ __('Send Password Reset Link') }}
            </button>

            <div class="reset-links">
                <a class="back-to-login" href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>