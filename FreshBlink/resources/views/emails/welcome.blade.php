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
        <p>Thank you for joining FreshBlink! We're excited to have you as part of our community.</p>
        
        <p>Here's what you can do now:</p>
        <ul>
            <li>Browse our wide selection of products</li>
            <li>Create and manage your wishlists</li>
            <li>Shop from our trusted sellers</li>
            <li>Track your orders</li>
            <li>Write reviews for products you've purchased</li>
        </ul>
        
        <p>To get started, you can:</p>
        <a href="{{ url('/products') }}" class="button">Browse Products</a>
        
        <p>If you have any questions or need assistance, our support team is here to help!</p>
        
        <p>Best regards,<br>The FreshBlink Team</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} FreshBlink. All rights reserved.</p>
    </div>
</body>
</html> 