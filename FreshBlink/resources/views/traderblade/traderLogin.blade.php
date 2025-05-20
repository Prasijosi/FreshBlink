<!DOCTYPE html>
<html>
<head>
    <title>Trader Login</title>
</head>
<body>

    <h2>Trader Login</h2>

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif

    <form method="POST" action="{{ url('/trader/login') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

</body>
</html>
