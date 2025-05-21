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
=======
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta tags for character encoding and responsive design -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <!-- Page title -->
  <title>Invoice - FreshBlink</title>
  
  <!-- External stylesheet for invoice styling -->
  <link rel="stylesheet" href="/css/invoice.css" />
  
  <!-- Google Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

  <!-- ======================= NAVBAR ======================= -->
  <div class="navbar">
    <div class="logo">
      <a href="#"><img src="images/logo2.png" alt="FreshBlink Logo"></a>
    </div>
    <div class="search-box">
      <input type="text" placeholder="Search Products......." />
      <button><span class="material-icons">search</span></button>
    </div>
    <div class="nav-actions">
      <a href="#"><span class="material-icons">favorite_border</span> Saved</a>
      <a href="#"><span class="material-icons">shopping_cart</span> Cart</a>
      <a href="#">Register</a>
      <button class="login-btn">Login</button>
    </div>
  </div>

  <!-- ======================= BREADCRUMB BAR ======================= -->
  <div class="bottom-bar">
    <span>Invoice</span>
    <span class="breadcrumb">Invoice &gt; Home</span>
  </div>

  <!-- ======================= INVOICE MAIN CONTENT ======================= -->
  <div class="invoice-container">
    <div class="invoice-header">
      <button class="download-btn">
        <span class="material-icons">arrow_back</span> Download Invoice
      </button>
      <img src="images/logo2.png" alt="FreshBlink Logo" class="invoice-logo"/>
    </div>

    <h2>INVOICE</h2>
    <p>User Id: #12345</p>
    <hr />

    <div class="invoice-details">
      <div>
        <p><strong>Billed to:</strong> FreshBlink </p>
        <p><strong>User Information:</strong> freshblink@gmail.com</p>
        <p><strong>Address:</strong> Thaathali</p>
        <p><strong>Contact Number:</strong> +123456789</p>
      </div>
      <div>
        <p><strong>Invoice Id:</strong> INV-2025-001</p>
        <p><strong>Invoice Date:</strong> 2025-05-01</p>
        <p><strong>Invoice Status:</strong> Paid</p>
      </div>
      <div>
        <p><strong>Invoice Total:</strong> $<span id="invoice-total">0.00</span></p>
        <p><strong>Due Date:</strong> 2025-05-07</p>
      </div>
    </div>

    <hr />

    <table class="invoice-table">
      <thead>
        <tr>
          <th>Item Detail</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <!-- JavaScript will populate this -->
      </tbody>
    </table>

    <div class="invoice-total">
      <strong>Total: $<span id="invoice-total-bottom">0.00</span></strong>
    </div>
  </div>

  <!-- ======================= FOOTER ======================= -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-logo">
        <img src="images/logo2.png" alt="FreshBlink Logo" />
      </div>
      <div class="footer-column">
        <h3>Account</h3>
        <ul>
          <li><a href="#">Wishlist</a></li>
          <li><a href="#">Cart</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Shipping Details</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Useful links</h3>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact us</a></li>
          <li><a href="#">Hot Deals</a></li>
          <li><a href="#">Promotions</a></li>
          <li><a href="#">New product</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Help Center</h3>
        <ul>
          <li><a href="#">Payment</a></li>
          <li><a href="#">Refund</a></li>
          <li><a href="#">Checkout</a></li>
          <li><a href="#">Q&amp;A</a></li>
          <li><a href="#">Shipping</a></li>
        </ul>
      </div>
    </div>
    <hr />
    <div class="copyright">
      <p>&copy; 2022, All rights reserved</p>
    </div>
    <div class="footer-bottom">
      <img src="images/paypal.webp" alt="PayPal" />
    </div>
  </footer>

  <!-- JavaScript for invoice table -->
  <script src="invoice.js"></script>
</body>
</html>
>>>>>>> c8e7fe1372ed5e79740f6066ee15fea25fa75dab
