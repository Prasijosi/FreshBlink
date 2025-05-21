@extends('emails.layouts.base')

@section('title', 'Welcome to FreshBlink Trader Program')

@section('header', 'Welcome to FreshBlink Trader Program!')

@section('content')
    <p>Hello {{ $trader->name }},</p>
    
    <p>Welcome to the FreshBlink Trader Program! We're excited to have you join our community of trusted local sellers. Together, we'll bring fresh, quality products to customers in your area.</p>
    
    <div class="points-info">
        <h3>📋 Application Status</h3>
        <p>Your application is currently under review. Our team will evaluate your submission and get back to you within 24-48 hours.</p>
    </div>
    
    <p>Here's what you can expect next:</p>
    <ul>
        <li>Our team will review your application within 24-48 hours</li>
        <li>You'll receive an email notification once your account is approved</li>
        <li>After approval, you can start setting up your shop profile</li>
        <li>Add your products and manage your inventory</li>
        <li>Start receiving orders from customers</li>
    </ul>
    
    <p>To prepare for your shop launch, you can:</p>
    <ul>
        <li>Gather high-quality product photos</li>
        <li>Prepare detailed product descriptions</li>
        <li>Set your pricing strategy</li>
        <li>Plan your delivery or pickup options</li>
    </ul>
    
    <p>If you have any questions or need assistance, our support team is here to help!</p>
    
    <p>Best regards,<br>The FreshBlink Team</p>
@endsection 