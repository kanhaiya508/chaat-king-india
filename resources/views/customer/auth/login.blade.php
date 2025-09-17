{{-- resources/views/customer/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-box {
            background: #fff;
            width: 380px;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-box h4 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 22px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.2);
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            background: #2575fc;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background: #1b5dd7;
        }

        label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            margin-bottom: 1rem;
            color: #555;
            cursor: pointer;
        }

        .text-danger {
            font-size: 13px;
            color: #e74c3c;
            margin-top: -5px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <form method="POST" action="{{ route('customer.login.post') }}">
            @csrf
            <h4>Customer Login</h4>

            <input type="email" name="email" value="test@example.com" placeholder="Email" required class="form-control"
                value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <input type="password" value="secret123" name="password" placeholder="Password" required class="form-control">

            <label><input type="checkbox" name="remember"> Remember me</label>

            <button class="btn">Login</button>
        </form>
    </div>

</body>

</html>
