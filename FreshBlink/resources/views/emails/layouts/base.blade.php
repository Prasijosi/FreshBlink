<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - FreshBlink</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4DAF22;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .content {
            padding: 30px 20px;
            background-color: #ffffff;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4DAF22;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s ease;
            border: none;
            font-size: 16px;
            line-height: 1.4;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(77, 175, 34, 0.2);
        }
        .button:hover {
            background-color: #3d8c1a;
            box-shadow: 0 4px 8px rgba(77, 175, 34, 0.3);
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f5f5f5;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #eee;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            color: #4DAF22;
            text-decoration: none;
            margin: 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
            font-weight: 600;
        }
        .total {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .points-info {
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #4DAF22;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="FreshBlink Logo" class="logo">
            <h1>@yield('header')</h1>
        </div>
        
        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
            <p>© {{ date('Y') }} FreshBlink. All rights reserved.</p>
            <p>This email was sent to {{ $user->email ?? $trader->email ?? 'you' }}</p>
        </div>
    </div>
</body>
</html> 