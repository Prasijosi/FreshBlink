@extends('emails.layouts.base')

@section('title', 'Trader Account Status Update')

@section('header', 'Trader Account Status Update')

@section('content')
    <p>Hello {{ $trader->name }},</p>

    @if($status === 'approved')
        <div class="points-info">
            <h3>🎉 Congratulations!</h3>
            <p>Your trader account has been approved. You can now start selling your products on FreshBlink!</p>
        </div>
        
        <p>Here's what you can do now:</p>
        <ul>
            <li>Set up your shop profile and branding</li>
            <li>Add your products with detailed descriptions</li>
            <li>Set up your inventory management system</li>
            <li>Configure your delivery or pickup options</li>
            <li>Start receiving and managing orders</li>
        </ul>
        
        <p>To get started, visit your dashboard:</p>
        <a href="{{ url('/trader/dashboard') }}" class="button">Go to Dashboard</a>
        
        <p>Need help getting started? Check out our <a href="{{ url('/trader/guide') }}">Trader Guide</a> for detailed instructions and best practices.</p>
    @else
        <div class="points-info" style="background-color: #fff3f3; border-left-color: #ff4444;">
            <h3>Application Status Update</h3>
            <p>We regret to inform you that your trader account application has been rejected at this time.</p>
        </div>
        
        <p>This could be due to one of the following reasons:</p>
        <ul>
            <li>Incomplete or inaccurate information provided</li>
            <li>Business documentation requirements not met</li>
            <li>Current market capacity limitations</li>
        </ul>
        
        <p>If you believe this is an error or would like to reapply, please contact our support team. We're here to help you through the process.</p>
        
        <a href="{{ url('/contact') }}" class="button">Contact Support</a>
    @endif
    
    <p>If you have any questions or need assistance, our support team is here to help!</p>
    
    <p>Best regards,<br>The FreshBlink Team</p>
@endsection 