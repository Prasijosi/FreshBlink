<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\Trader;
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
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $trader = Trader::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
        ]);

        return response()->json(['message' => 'Thank you, you will soon be notified when your account gets approved']);
    }

    public function showRegister(){
        return view('traderblade.register');
    }
}
