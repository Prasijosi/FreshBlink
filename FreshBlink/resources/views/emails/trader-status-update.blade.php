<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trader Account Status Update</title>
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
        <h1>Trader Account Status Update</h1>
    </div>
    <div class="content">
        <p>Hello {{ $trader->name }},</p>

        @if($status === 'approved')
            <p>Great news! Your trader account has been approved. You can now start selling your products on FreshBlink.</p>
            
            <p>Here's what you can do now:</p>
            <ul>
                <li>Set up your shop profile</li>
                <li>Add your products</li>
                <li>Manage your inventory</li>
                <li>Start receiving orders</li>
            </ul>
            
            <a href="{{ url('/trader/dashboard') }}" class="button">Go to Dashboard</a>
        @else
            <p>We regret to inform you that your trader account application has been rejected at this time.</p>
            
            <p>This could be due to one of the following reasons:</p>
            <ul>
                <li>Incomplete or inaccurate information provided</li>
                <li>Business documentation requirements not met</li>
                <li>Current market capacity limitations</li>
            </ul>
            
            <p>If you believe this is an error or would like to reapply, please contact our support team.</p>
            
            <a href="{{ url('/contact') }}" class="button">Contact Support</a>
        @endif
        
        <p>If you have any questions or need assistance, our support team is here to help!</p>
        
        <p>Best regards,<br>The FreshBlink Team</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} FreshBlink. All rights reserved.</p>
    </div>
</body>
</html> 