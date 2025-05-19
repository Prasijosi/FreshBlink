<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            font-weight: bold;
        }
        .points-info {
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
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
                    <td colspan="3" class="total">Subtotal:</td>
                    <td class="total">${{ number_format($order->total_order + $order->points_discount, 2) }}</td>
                </tr>
                @if($order->points_discount > 0)
                <tr>
                    <td colspan="3" class="total">Loyalty Points Discount:</td>
                    <td class="total">-${{ number_format($order->points_discount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td class="total">${{ number_format($order->total_order, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="points-info">
            <h3>Loyalty Points Update</h3>
            @if($order->points_discount > 0)
            <p>Points Used: {{ ceil($order->points_discount * 100) }} points</p>
            <p>Points Discount: ${{ number_format($order->points_discount, 2) }}</p>
            @endif
            <p>Points Earned: {{ floor($order->total_order) }} points</p>
            <p>Current Balance: {{ $order->user->customer->loyalty_points }} points</p>
        </div>

        <h3>Collection Details:</h3>
        <p>Date: {{ $order->collectionSlot->slot_date->format('F j, Y') }}</p>
        <p>Time: {{ $order->collectionSlot->time_details->format('g:i A') }}</p>
        
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