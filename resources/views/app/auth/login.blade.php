<x-layouts.auth title="Login">
    <div class="auth-card">

        <div class="auth-title">Login to Your Account</div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <i class="ri-mail-line input-icon"></i>
                <input type="email" name="email" placeholder="Email Address" required
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">

            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <i class="ri-lock-2-line input-icon"></i>
                <input type="password" name="password" placeholder="Password" required
                    class="form-control @error('password') is-invalid @enderror">

            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-purple w-100">Login</button>
        </form>
    </div>

</x-layouts.auth>
