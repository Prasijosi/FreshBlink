<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function create()
    {
        return view('traderblade.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Shop::create([
        'trader_id' => Auth::guard('trader')->user()->id,
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('traderhome')->with('success', 'Shop created successfully!');

}
//Fix $shops error

public function home()
{
    $shops = Shop::where('trader_id', Auth::guard('trader')->user()->id)->get();
    return view('traderblade.traderhome', compact('shops'));
}
}
