<x-layouts.auth title="Login">
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <x-input-field name="name" placeholder="Full Name" />
        <x-input-field name="email" type="email" placeholder="Email Address" />
        <x-input-field name="password" type="password" placeholder="Password" />
        <x-input-field name="password_confirmation" type="password" placeholder="Confirm Password" />

        <x-button>Register</x-button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}">Already have an account? Login</a>
    </div>
</x-layouts.auth>
