<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:trader')->except(['index', 'show']);
    }

    public function index()
    {
        $shops = Shop::with(['trader', 'products'])->paginate(12);
        return view('userblade.shops.index', compact('shops'));
    }

    public function show(Shop $shop)
    {
        $shop->load(['trader', 'products' => function ($query) {
            $query->where('status', 'active');
        }]);
        return view('userblade.shops.show', compact('shop'));
    }

    public function create()
    {
        return view('traderblade.shops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'opening_hours' => 'required|string|max:255',
            'closing_hours' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['trader_id'] = Auth::user()->trader->id;
        $validated['status'] = 'active';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        Shop::create($validated);

        return redirect()->route('trader.dashboard')
            ->with('success', 'Shop created successfully');
    }

    public function edit(Shop $shop)
    {
        $this->authorize('update', $shop);
        return view('traderblade.shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'opening_hours' => 'required|string|max:255',
            'closing_hours' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shop->update($validated);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $shop->image = $imageName;
            $shop->save();
        }

        return redirect()->route('trader.dashboard')
            ->with('success', 'Shop updated successfully');
    }

    public function destroy(Shop $shop)
    {
        $this->authorize('delete', $shop);
        $shop->delete();

        return redirect()->route('trader.dashboard')
            ->with('success', 'Shop deleted successfully');
    }

    public function products(Shop $shop)
    {
        $this->authorize('view', $shop);
        $products = $shop->products()->paginate(12);
        return view('traderblade.shops.products', compact('shop', 'products'));
    }

    public function orders(Shop $shop)
    {
        $this->authorize('view', $shop);
        $orders = $shop->orders()->latest()->paginate(12);
        return view('traderblade.shops.orders', compact('shop', 'orders'));
    }
} 