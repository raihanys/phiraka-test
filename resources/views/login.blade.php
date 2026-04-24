<!DOCTYPE html>
<html>

<head>
    <title>Login - Phiraka Test</title>
</head>

<body style="font-family: Arial; padding: 50px;">

    <h2>FORM LOGIN</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom: 15px;">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div style="margin-bottom: 10px;">
            <label>Username</label><br>
            <input type="text" name="Username" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Password</label><br>
            <input type="password" name="Password" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Security Image</label><br>
            <img src="{{ route('captcha') }}" alt="Captcha" style="border: 1px solid #000; margin-bottom: 5px;"><br>
            <label>Input karakter yang muncul pada tampilan diatas</label><br>
            <input type="text" name="captcha" required>
        </div>

        <button type="submit">Submit</button>
    </form>

</body>

</html>
