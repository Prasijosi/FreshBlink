@extends('emails.layouts.base')

@section('title', 'Welcome to FreshBlink')

@section('header', 'Welcome to FreshBlink!')

@section('content')
    <p>Hello {{ $user->name }},</p>
    
    <p>Welcome to FreshBlink! We're thrilled to have you join our community of fresh food enthusiasts. Get ready to discover amazing local products and connect with trusted sellers in your area.</p>
    
    <div class="points-info">
        <h3>🎉 Special Welcome Bonus!</h3>
        <p>As a new member, you've received 100 loyalty points to get started. Use these points to get discounts on your future purchases!</p>
    </div>
    
    <p>Here's what you can do now:</p>
    <ul>
        <li>Browse our wide selection of fresh products</li>
        <li>Create and manage your wishlists</li>
        <li>Shop from our trusted local sellers</li>
        <li>Track your orders in real-time</li>
        <li>Earn and redeem loyalty points</li>
    </ul>
    
    <p>To get started, explore our marketplace:</p>
    <a href="{{ url('/products') }}" class="button">Browse Products</a>
    
    <p>If you have any questions or need assistance, our support team is here to help!</p>
    
    <p>Best regards,<br>The FreshBlink Team</p>
@endsection 