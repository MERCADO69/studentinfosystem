<x-guest-layout>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .register-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 48px;
            width: 100%;
            max-width: 800px;
            /* Increased width to accommodate wider fields */
            margin: 50px auto;
            transition: all 0.3s ease;
        }

        .register-container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .register-title {
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

        .register-button {
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

        .register-button:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .register-links {
            text-align: center;
            margin-top: 20px;
        }

        .login-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .login-link:hover {
            color: #3b82f6;
        }

        .form-group {
            margin-bottom: 24px;
            display: flex;
            gap: 16px;
            /* Space between two fields */
        }

        .form-group>div {
            flex: 1;
            /* Each field takes equal space */
            min-width: 0;
            /* Prevent wrapping */
        }
    </style>

    <div class="register-container">
        <h1 class="register-title">Student Registration</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Student ID and Last Name -->
            <div class="form-group">
                <div>
                    <x-input-label for="student_id" :value="__('Student ID')" class="input-label" />
                    <x-text-input id="student_id" class="form-input" type="text" name="student_id"
                        :value="old('student_id')" required maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" class="input-label" />
                    <x-text-input id="last_name" class="form-input" type="text" name="last_name"
                        :value="old('last_name')" required
                        oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" />
                </div>
            </div>

            <!-- First Name and Course -->
            <div class="form-group">
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" class="input-label" />
                    <x-text-input id="first_name" class="form-input" type="text" name="first_name"
                        :value="old('first_name')" required
                        oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" />
                </div>
                <div>
                    <x-input-label for="course" :value="__('Course')" class="input-label" />
                    <x-text-input id="course" class="form-input" type="text" name="course" :value="old('course')"
                        required />
                </div>
            </div>

            <!-- Year Level and Email -->
            <div class="form-group">
                <div>
                    <x-input-label for="year_level" :value="__('Year Level')" class="input-label" />
                    <select name="year_level" id="year_level" class="form-input" required>
                        <option value="" disabled selected>Select YL</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="email" :value="__('Email')" class="input-label" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')"
                        required />
                </div>
            </div>

            <button type="submit" class="register-button">
                {{ __('Register') }}
            </button>

            <div class="register-links">
                <a class="login-link" href="{{ route('login') }}">Already registered?</a>
            </div>
        </form>
    </div>
</x-guest-layout>