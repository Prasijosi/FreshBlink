<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trader;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'phone' => 'nullable|string|max:15',
            'trader_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $trader = Trader::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'trader_type' => $request->trader_type,
        ]);

        return redirect()->route('login')->with('success', 'Thank you! You will be notified once approved.');
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
        $credential = $request->only('email', 'password');

        if (Auth::guard('trader')->attempt($credential)) {
            $trader = Auth::guard('trader')->user();

            if ($trader->status !== 'approved') {
                Auth::guard('trader')->logout();
                return redirect()->back()->with('error', 'Your account is not approved yet');
            }
            return view('traderblade.traderhome')->with('success', 'Logged in sucessfully');
        }
        return redirect()->back()->with('error', 'Invalid email or password.');

        // Auth::guard('trader')->login($trader);
        // return redirect()->intended('/trader/dashboard')->with('success','Logged in successfully');
    }
    public function logout()
    {
        Auth::guard('trader')->logout();
        return redirect('/trader/login')->with('success', 'Logged out successfully.');
    }

    //Shop funcitonality

    public function home()
    {
        $traderId = Auth::guard('trader')->user()->id;

        $shops = Shop::where('trader_id', $traderId)->get();

        return view('traderblade.traderhome', compact('shops'));
    }
}
