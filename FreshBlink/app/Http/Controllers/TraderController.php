<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\Trader;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\TraderWelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TraderController extends Controller
{
    /**
     * Handles the registration of a new trader.
     *
     * This function validates the incoming request data, creates a new trader
     * record in the database, and returns a success message.
     *
     * @param Request $request The HTTP request containing trader registration data.
     * @return \Illuminate\Http\JsonResponse JSON response with success or error message.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:traders',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'trader_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $trader = Trader::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone_number,
            'trader_type' => $request->trader_type,
            'status' => 'pending', // Set initial status as pending
        ]);

        // Send welcome email
        try {
            Mail::to($trader->email)->send(new TraderWelcomeEmail($trader));
            return redirect()->route('trader.register')->with('success', 'Registration successful! Please check your email for further instructions.');
        } catch (\Exception $e) {
            // Log the error and show it to the user for debugging
            Log::error('Failed to send trader welcome email: ' . $e->getMessage());
            return redirect()->route('trader.register')
                ->with('error', 'Registration successful, but there was an issue sending the welcome email: ' . $e->getMessage());
        }
    }

    public function showRegister()
    {
        return view('traderblade.register');
    }

    //Trader Login session starts from here

    public function showLoginForm()
    {
        return view('traderblade.traderLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('trader')->attempt($credentials)) {
            $trader = Auth::guard('trader')->user();

            if ($trader->status !== 'approved') {
                Auth::guard('trader')->logout();
                return redirect()->back()->with('error', 'Your account is not approved yet');
            }
            return redirect()->route('trader.dashboard')->with('success', 'Logged in successfully');
        }
        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::guard('trader')->logout();
        return redirect('/trader/login')->with('success', 'Logged out successfully.');
    }
}
