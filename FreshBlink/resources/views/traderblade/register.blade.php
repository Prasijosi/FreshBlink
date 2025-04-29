<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trader Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h2>Trader Registration Form</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ url('/trader/register') }}">
        @csrf
        <label for="name">Full Name:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirmation">Confirm Password:</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" required><br><br>

        <label for="trader_type">Enter your trader type:</label><br>
        <input type="text" name="trader_type" id="trader_type" required><br><br>

        <label for="phone_number">Phone Number (optional):</label><br>
        <input type="text" name="phone_number" id="phone_number"><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
