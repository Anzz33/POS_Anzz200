<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(10, 10, 12, 0.8), rgba(10, 10, 12, 0.88)), 
                        url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 1rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: rgba(30, 34, 42, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            padding: 2.5rem;
        }

        .input-dark {
            background-color: rgba(15, 17, 23, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            padding: 0.75rem 1rem;
        }

        .input-dark::placeholder {
            color: #a0aec0 !important;
        }

        .input-dark:focus {
            background-color: rgba(15, 17, 23, 0.8) !important;
            border-color: #d4af37 !important;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
            color: #ffffff !important;
        }

        /* Fix Background Autofill Browser */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #11141a inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">CAFE & STORE POS</span>
        <h3 class="fw-bold text-white m-0">Login POS</h3>
        <p class="small text-white-50 mt-1">Masukkan kredensial akun kamu untuk masuk</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 bg-danger bg-opacity-25 text-danger small rounded-3 mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label small text-white-50">Email Address</label>
            <input type="email" name="email" class="form-control input-dark rounded-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            @error('email')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="form-label small text-white-50">Password</label>
            <input type="password" name="password" class="form-control input-dark rounded-3 @error('password') is-invalid @enderror" placeholder="••••••••" required>
            @error('password')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 rounded-3 text-dark shadow-sm">
            Login
        </button>
    </form>
</div>

</body>
</html>