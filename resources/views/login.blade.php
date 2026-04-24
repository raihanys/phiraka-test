<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Phiraka Test</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

    <div class="floating-switch">
        <a href="{{ route('fibonacci') }}" class="btn-switch">
            Fibonacci Grid
        </a>
    </div>

    <div id="toast-container"></div>

    <div class="page-center">
        <div class="card login-card">
            <div class="login-logo">Phiraka Sinergi Indonesia</div>
            <p class="login-sub">Masuk ke sistem manajemen user</p>

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" id="Username" name="Username" value="{{ old('Username') }}" required>
                </div>

                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="Password" required>
                </div>

                <div class="form-group">
                    <div style="margin-top: 30px" class="g-recaptcha"
                        data-sitekey="{{ config('services.recaptcha.site') }}"></div>
                </div>

                <button type="submit" class="btn btn-primary btn-full" style="margin-top:8px;">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if ($errors->any())
            showToast('{{ $errors->first() }}', 'error');
        @endif

        function showToast(message, type = 'success', redirect = false, redirectUrl = '') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <span class="toast-icon">${type === 'success' ? '✓' : '✕'}</span>
                <span>${message}</span>
            `;
            container.appendChild(toast);

            const duration = redirect ? 1800 : 2000;
            setTimeout(() => {
                toast.classList.add('out');
                setTimeout(() => {
                    toast.remove();
                    if (redirect && redirectUrl) window.location.href = redirectUrl;
                }, 300);
            }, duration);
        }
    </script>
</body>

</html>
