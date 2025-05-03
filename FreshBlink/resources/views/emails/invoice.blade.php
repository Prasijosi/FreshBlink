<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your FreshBlink Order Invoice</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 1.2em;
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
        <h1>Order Invoice #{{ $order->id }}</h1>
    </div>
    <div class="content">
        <p>Hello {{ $order->user->name }},</p>
        <p>Thank you for your order with FreshBlink. Here's your order details:</p>
        
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderProducts as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total Amount:</td>
                    <td class="total">${{ number_format($order->total_order, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <p><strong>Collection Details:</strong></p>
        <p>Date: {{ $order->collectionSlot->slot_date }}</p>
        <p>Time: {{ $order->collectionSlot->time_details }}</p>
        
        <p>Payment Method: {{ ucfirst($order->payment->payment_method) }}</p>
        <p>Transaction ID: {{ $order->payment->transaction_pin }}</p>
        
        <p>If you have any questions about your order, please contact our support team.</p>
        
        <p>Best regards,<br>The FreshBlink Team</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} FreshBlink. All rights reserved.</p>
    </div>
</body>
</html> 