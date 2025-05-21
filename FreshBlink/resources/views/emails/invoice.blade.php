<<<<<<< HEAD
@extends('emails.layouts.base')

@section('title', 'Order Invoice')

@section('header', 'Order Invoice #{{ $order->id }}')

@section('content')
    <p>Hello {{ $order->user->name }},</p>
    
    <p>Thank you for your order with FreshBlink! We're preparing your items with care. Here's your order details:</p>
    
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

    @if($order->points_discount > 0)
    <div class="points-info">
        <h3>💫 Loyalty Points Used</h3>
        <p>You saved ${{ number_format($order->points_discount, 2) }} using your loyalty points!</p>
    </div>
    @endif

    <p>Order Status: <strong>{{ ucfirst($order->status) }}</strong></p>
    
    <p>You can track your order status here:</p>
    <a href="{{ url('/orders/' . $order->id) }}" class="button">Track Order</a>
    
    <p>If you have any questions about your order, please don't hesitate to contact our support team.</p>
    
    <p>Best regards,<br>The FreshBlink Team</p>
@endsection 