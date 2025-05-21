@extends('emails.layouts.base')

@section('title', 'Reset Your Password')

@section('header', 'Reset Your Password')

@section('content')
    <p>Hello {{ $user->name }},</p>
    
    <p>We received a request to reset your FreshBlink account password. To proceed with the password reset, please click the button below:</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $resetLink }}" class="button">Reset Password</a>
    </div>
    
    <div class="points-info">
        <h3>🔒 Security Notice</h3>
        <p>This password reset link will expire in 60 minutes. If you did not request a password reset, please ignore this email or contact our support team if you have concerns about your account security.</p>
    </div>
    
    <p>If the button above doesn't work, you can copy and paste this link into your browser:</p>
    <p style="word-break: break-all; color: #666; font-size: 14px;">{{ $resetLink }}</p>
    
    <p>For security reasons, please:</p>
    <ul>
        <li>Choose a strong password that you haven't used before</li>
        <li>Don't share your password with anyone</li>
        <li>Enable two-factor authentication for additional security</li>
    </ul>
    
    <p>If you have any questions or need assistance, our support team is here to help!</p>
    
    <p>Best regards,<br>The FreshBlink Team</p>
@endsection 