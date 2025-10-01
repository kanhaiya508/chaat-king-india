<x-layouts.auth title="Login">
    <div class="text-center mb-4">
        <h4 class="mb-1" style="color: #fff; font-weight: 800; font-size: 28px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
            Tabletray
        </h4>
        <p class="mb-0" style="color: rgba(255, 255, 255, 0.9); font-weight: 600; font-size: 16px; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
            Smart Food Billing & Management
        </p>
    </div>
    
    <div class="auth-card">
        <div class="auth-title">Welcome Back! 👋</div>
        <p class="text-center text-muted mb-4" style="color: rgba(255, 75, 43, 0.7); font-weight: 500;">
            Sign in to continue to Chaat King India
        </p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <i class="ri-mail-line input-icon"></i>
                <input type="email" name="email" placeholder="Enter your email address" required
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <i class="ri-lock-2-line input-icon"></i>
                <input type="password" name="password" id="password" placeholder="Enter your password" required
                    class="form-control @error('password') is-invalid @enderror">
                <i class="ri-eye-line password-toggle" onclick="togglePassword()"></i>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror


            <button type="submit" class="btn btn-purple w-100 mb-3">
                <i class="ri-login-box-line me-2"></i>
                Sign In
            </button>

            <div class="text-center">
                <p class="mb-0" style="color: rgba(255, 75, 43, 0.6); font-size: 12px;">
                    Powered by Ansdesk
                </p>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('ri-eye-line');
                toggleIcon.classList.add('ri-eye-off-line');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('ri-eye-off-line');
                toggleIcon.classList.add('ri-eye-line');
            }
        }
    </script>
</x-layouts.auth>
