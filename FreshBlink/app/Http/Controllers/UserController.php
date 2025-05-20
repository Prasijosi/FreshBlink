<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('userblade.login');
    }

    // Process login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        // Attempt to authenticate
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            // Check if user is active
            $user = Auth::user();
            if ($user->is_active === false) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been deactivated. Please contact an administrator.']);
            }

            $request->session()->regenerate();
            
            // If there's a cart in session, transfer it to the user's account
            if ($request->session()->has('cart')) {
                app(CartController::class)->transferSessionCart();
            }
            
            return redirect()->intended('dashboard');
        }
        
        // Check if the user exists but password is incorrect
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            // User exists but password is wrong
            return back()->withErrors([
                'password' => 'The password you entered is incorrect.',
            ])->withInput(['email' => $request->email]);
        }
        
        // Fallback error (shouldn't normally get here due to exists validation)
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show registration form
    public function showRegister()
    {
        // Send password requirements to the view
        $passwordRequirements = [
            'Minimum 8 characters',
            'At least one uppercase letter',
            'At least one lowercase letter',
            'At least one number',
            'At least one special character (!@#$%^&*)',
            'Cannot be a commonly used password'
        ];
        
        return view('userblade.register', compact('passwordRequirements'));
    }

    // Process registration request
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agree' => 'required'
        ], [
            'email.unique' => 'This email is already registered. Please use a different email or try to login.',
            'password.min' => 'The password must be at least 8 characters.',
            'agree.required' => 'You must agree to the terms and conditions.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_role' => 'customer',
                'is_active' => true,
                'remember_token' => Str::random(60),
            ]);

            // Create customer profile
            Customer::create([
                'user_id' => $user->id,
                'notification_preference' => 'email',
                'loyalty_points' => 0,
                'favorite_shop' => null,
            ]);

            DB::commit();

            // Send welcome email
            try {
                Mail::to($user->email)->send(new WelcomeEmail($user));
            } catch (\Exception $e) {
                Log::error('Failed to send welcome email: ' . $e->getMessage());
                // Continue with registration even if email fails
            }

            Auth::login($user);

            return redirect('dashboard')->with('success', 'Registration successful! Please check your email for a welcome message.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    // Show user profile
    public function profile()
    {
        $user = Auth::user();
        $customer = $user->customer;
        
        return view('userblade.profile', compact('user', 'customer'));
    }

    // Show edit profile form
    public function showEditProfile()
    {
        $user = Auth::user();
        return view('userblade.edit_profile', compact('user'));
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'contact_details' => 'required|string|min:10',
            'address' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_details' => $request->contact_details,
            'address' => $request->address,
        ]);

        if ($request->has('notification_preference')) {
            Customer::where('user_id', $user->id)->update([
                'notification_preference' => $request->notification_preference,
            ]);
        }

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully');
    }

    // Show change password form
    public function showChangePassword()
    {
        // Send password requirements to the view
        $passwordRequirements = [
            'Minimum 8 characters',
            'At least one uppercase letter',
            'At least one lowercase letter',
            'At least one number',
            'At least one special character (!@#$%^&*)',
            'Cannot be a commonly used password'
        ];
        
        return view('userblade.change_password', compact('passwordRequirements'));
    }

    // Process change password
    public function changePassword(Request $request)
    {
        // Custom validation rules
        Validator::extend('uppercase', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[A-Z]/', $value);
        });
        
        Validator::extend('lowercase', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[a-z]/', $value);
        });
        
        Validator::extend('number', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[0-9]/', $value);
        });
        
        Validator::extend('special_char', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[^A-Za-z0-9]/', $value);
        });
    
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => [
                'required', 
                'confirmed', 
                'min:8',
                'uppercase',
                'lowercase',
                'number',
                'special_char',
                PasswordRule::min(8)->uncompromised()
            ],
        ], [
            'password.uppercase' => 'The password must contain at least one uppercase letter.',
            'password.lowercase' => 'The password must contain at least one lowercase letter.',
            'password.number' => 'The password must contain at least one number.',
            'password.special_char' => 'The password must contain at least one special character.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.uncompromised' => 'The password has appeared in a data leak. Please choose a different password.',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('current_password', 'password', 'password_confirmation'));
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        // Log out from all other devices
        Auth::logoutOtherDevices($request->current_password);

        return redirect()->route('user.profile')->with('success', 'Password changed successfully. You have been logged out from all other devices.');
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    // Show forgot password form
    public function showForgotPassword()
    {
        return view('userblade.forgot_password');
    }

    // Process forgot password request
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Password reset link has been sent to your email.');
        }

        return back()->withErrors(['email' => 'Unable to send password reset link. Please try again.']);
    }

    // Show reset password form
    public function showResetPassword(Request $request)
    {
        return view('userblade.reset_password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    // Process reset password request
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required', 
                'confirmed', 
                'min:8',
                'uppercase',
                'lowercase',
                'number',
                'special_char',
                PasswordRule::min(8)->uncompromised()
            ],
        ], [
            'password.uppercase' => 'The password must contain at least one uppercase letter.',
            'password.lowercase' => 'The password must contain at least one lowercase letter.',
            'password.number' => 'The password must contain at least one number.',
            'password.special_char' => 'The password must contain at least one special character.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.uncompromised' => 'The password has appeared in a data leak. Please choose a different password.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Your password has been reset successfully. Please login with your new password.');
        }

        return back()->withErrors(['email' => 'Unable to reset password. Please try again.']);
    }
} 