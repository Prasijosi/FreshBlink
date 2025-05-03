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
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $trader = Trader::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone_number,
            'status' => 'pending', // Set initial status as pending
        ]);

        // Send welcome email
        try {
            Mail::to($trader->email)->send(new TraderWelcomeEmail($trader));
            return redirect()->route('trader.register')->with('success', 'Registration successful! Please check your email for further instructions.');
        } catch (\Exception $e) {
            // Log the error but still show success to user
            Log::error('Failed to send trader welcome email: ' . $e->getMessage());
            return redirect()->route('trader.register')->with('success', 'Registration successful!');
        }
    }

    public function showRegister()
    {
        return view('traderblade.register');
    }
}
