<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
<div class="container">
    <div class="leaf">🌻</div>
    <h2>Welcome!</h2>
    <h4>Please log in to continue</h4>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <input type="text" name="username" placeholder="Enter Username"><br>
        <input type="password" id="password" name="password" placeholder="Enter Password"><br>
        <input type="checkbox" onclick="togglePassword()"> <span class="show-pass">Show Password</span><br>
        <button type="submit">LOG IN</button>
    </form>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
</div>

<script>
function togglePassword() {
    var x = document.getElementById("password");
    x.type = x.type === "password" ? "text" : "password";
}
</script>
</body>
</html>
