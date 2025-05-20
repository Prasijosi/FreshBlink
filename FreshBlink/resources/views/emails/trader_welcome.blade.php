<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to FreshBlink Trader Program</title>
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
        <h1>Welcome to FreshBlink Trader Program!</h1>
    </div>
    <div class="content">
        <p>Hello {{ $trader->name }},</p>
        <p>Thank you for registering as a trader with FreshBlink. We're excited to have you join our marketplace!</p>
        
        <p>Your application is currently under review. Our team will evaluate your submission and get back to you soon.</p>
        
        <p>Here's what you can expect next:</p>
        <ul>
            <li>Our team will review your application within 24-48 hours</li>
            <li>You'll receive an email notification once your account is approved</li>
            <li>After approval, you can start setting up your shop and listing products</li>
        </ul>
        
        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
        
        <p>Best regards,<br>The FreshBlink Team</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} FreshBlink. All rights reserved.</p>
    </div>
</body>
</html> 