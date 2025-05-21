<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\WishlistProduct;
use App\Models\Review;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Shop;
use App\Models\Trader;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class TraderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('guest:trader')->except(['logout', 'dashboard', 'profile', 'updateProfile']);
        $this->middleware('auth:trader')->only(['dashboard', 'profile', 'updateProfile']);
    }

    public function showRegister()
    {
        return view('traderblade.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'trader_type' => 'required|string|in:' . implode(',', array_keys(Trader::TRADER_TYPES)),
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        // Create trader
        $trader = Trader::create([
            'user_id' => $user->id,
            'trader_type' => $request->trader_type,
            'trader_status' => 'pending',
        ]);

        // Log in the trader
        Auth::guard('trader')->login($trader);

        return redirect()->route('trader.dashboard')
            ->with('success', 'Registration successful! Please wait for admin approval.');
    }

    public function showLoginForm()
    {
        return view('userblade.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('trader')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $trader = Auth::guard('trader')->user();
            if ($trader->trader_status !== 'approved') {
                Auth::guard('trader')->logout();
                return back()->withErrors([
                    'email' => 'Your account is pending approval. Please wait for admin approval.',
                ])->withInput();
            }

            return redirect()->intended(route('trader.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('trader')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('trader.login');
    }

    public function dashboard()
    {
        $trader = Auth::guard('trader')->user();
        $shops = Shop::where('trader_id', $trader->user_id)->get();
        $products = Product::whereIn('shop_id', $shops->pluck('id'))->get();
        $orders = Order::whereIn('shop_id', $shops->pluck('id'))->latest()->take(5)->get();

        return view('traderblade.dashboard', compact('shops', 'products', 'orders'));
    }

    public function profile()
    {
        $trader = Auth::guard('trader')->user();
        return view('traderblade.profile', compact('trader'));
    }

    public function updateProfile(Request $request)
    {
        $trader = Auth::guard('trader')->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update user info
        $user = $trader->user;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/traders'), $imageName);
            $trader->image = 'images/traders/' . $imageName;
            $trader->save();
        }

        return back()->with('success', 'Profile updated successfully');
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $query->where('product_category_id', $request->category);
        }

        if ($request->has('shop')) {
            $query->where('shop_id', $request->shop);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = ProductCategory::all();

        return view('userblade.category', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                                  ->where('id', '!=', $id)
                                  ->limit(4)
                                  ->get();
        $reviews = Review::where('product_id', $id)->latest()->get();

        $inWishlist = false;
        if (Auth::check()) {
            $inWishlist = Wishlist::where('user_id', Auth::id())
                                  ->whereHas('wishlistProducts', function($query) use ($id) {
                                      $query->where('product_id', $id);
                                  })->exists();
        }

        return view('userblade.product_detail', compact('product', 'relatedProducts', 'reviews', 'inWishlist'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $products = Product::where('product_name', 'like', '%' . $keyword . '%')
                           ->orWhere('description', 'like', '%' . $keyword . '%')
                           ->paginate(12);

        return view('products.search', compact('products', 'keyword'));
    }

    public function addToWishlist($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add products to wishlist');
        }

        $user = Auth::user();
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'wishlist_name' => 'My Wishlist'
        ]);

        $exists = $wishlist->wishlistProducts()->where('product_id', $id)->exists();

        if (!$exists) {
            $wishlist->wishlistProducts()->create(['product_id' => $id]);
            return back()->with('success', 'Product added to wishlist');
        }

        return back()->with('info', 'Product already in wishlist');
    }

    public function removeFromWishlist($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', Auth::id())->first();

        if ($wishlist) {
            $wishlist->wishlistProducts()->where('product_id', $id)->delete();
            return back()->with('success', 'Product removed from wishlist');
        }

        return back()->with('error', 'Product not found in wishlist');
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->quantity ?? 1;

        if ($product->quantity < $quantity) {
            return back()->with('error', 'Not enough stock available');
        }

        if (!Auth::check()) {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'product_id' => $id,
                    'product_name' => $product->product_name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'image' => $product->product_image,
                ];
            }
            session()->put('cart', $cart);
            return back()->with('success', 'Product added to cart');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cartProduct = $cart->cartProducts()->where('product_id', $id)->first();

        if ($cartProduct) {
            $cartProduct->update(['quantity' => $cartProduct->quantity + $quantity]);
        } else {
            $cart->cartProducts()->create(['product_id' => $id, 'quantity' => $quantity]);
        }

        return back()->with('success', 'Product added to cart');
    }

    public function submitReview(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to submit a review');
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'review_date' => now(),
        ]);

        return back()->with('success', 'Review submitted successfully');
    }

    public function traderIndex()
    {
        $trader = Auth::guard('trader')->user();

        $products = Product::with(['shop', 'category'])
            ->where('user_id', $trader->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $shops = Shop::where('trader_id', $trader->id)->get();
        $categories = ProductCategory::all();

        return view('traderblade.index', compact('products', 'shops', 'categories'));
    }

    public function traderCreate()
    {
        $traderId = Auth::guard('trader')->user()->id;
        $shops = Shop::where('trader_id', $traderId)->get();
        $categories = ProductCategory::all();

        return view('traderblade.addproduct', compact('shops', 'categories'));
    }

    public function traderStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'min_order' => 'required|integer',
            'max_order' => 'nullable|integer',
            'stock_no' => 'nullable|string',
            'shop_id' => 'required|exists:shops,id',
            'product_category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = Auth::guard('trader')->id();

        Product::create($validated);

        return redirect()->route('trader.products')->with('success', 'Product saved successfully!');
    }
}
