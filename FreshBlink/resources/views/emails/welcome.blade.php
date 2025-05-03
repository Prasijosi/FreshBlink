<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to FreshBlink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 0 0 5px 5px;
        }
        .otp-box {
            background-color: #fff;
            border: 2px solid #4CAF50;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to FreshBlink!</h1>
    </div>
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        <p>Thank you for registering with FreshBlink. We're excited to have you on board!</p>
        
        <p>To complete your registration, please use the following OTP to verify your email address:</p>
        
        <div class="otp-box">
            {{ $otp }}
        </div>
        
        <p>This OTP will expire in 15 minutes. If you didn't request this verification, please ignore this email.</p>
        
        <p>Best regards,<br>The FreshBlink Team</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} FreshBlink. All rights reserved.</p>
    </div>
</body>
</html> 