<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\Report;
use App\Models\Discount;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\TraderStatusUpdateEmail;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        // Check if user is an admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access');
        }
        
        // Get statistics for dashboard
        $totalUsers = User::count();
        $totalShops = Shop::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $pendingReports = Report::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalShops',
            'totalProducts',
            'totalOrders',
            'recentOrders',
            'pendingReports'
        ));
    }

    // Trader management
    public function index(Request $request)
    {
        $query = Trader::query();
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('trader_status', $request->status);
        }
        
        // Filter by trader type
        if ($request->has('type')) {
            $query->where('trader_type', $request->type);
        }
        
        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $traders = $query->latest()->paginate(10);
        $traderTypes = Trader::distinct()->pluck('trader_type');
        
        return view('adminblade.traders', compact('traders', 'traderTypes'));
    }

    public function showTrader($id)
    {
        $trader = Trader::with(['products', 'orders'])->findOrFail($id);
        return view('adminblade.trader-details', compact('trader'));
    }

    public function approve($user_id)
    {
        $trader = Trader::findOrFail($user_id);
        $trader->trader_status = 'approved';
        $trader->save();
        // Optionally notify trader via email
        return redirect()->back()->with('success', 'Trader has been approved successfully');
    }

    public function reject($user_id)
    {
        $trader = Trader::findOrFail($user_id);
        $trader->trader_status = 'rejected';
        $trader->save();
        // Optionally notify trader via email
        return redirect()->back()->with('success', 'Trader has been rejected');
    }

    public function getTraderDetails($id)
    {
        $trader = Trader::with(['products', 'orders'])->findOrFail($id);
        return view('adminblade.trader-details-partial', compact('trader'));
    }

    // Show admin login form
    public function showLogin()
    {
        return view('admin.login');
    }

    // Process admin login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user is an admin
            if ($user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }
            
            // If not an admin, logout and return with error
            Auth::logout();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you are not an admin.',
        ])->onlyInput('email');
    }

    // Manage users
    public function manageUsers()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Show user details
    public function showUser($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $user = User::with(['customer', 'trader'])->findOrFail($id);
        $orders = Order::where('user_id', $id)->latest()->take(10)->get();
        
        return view('admin.users.show', compact('user', 'orders'));
    }

    // Deactivate/Activate user
    public function toggleUserStatus($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User has been {$status} successfully");
    }

    // Manage shops
    public function manageShops()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $shops = Shop::with('user')->paginate(15);
        return view('admin.shops.index', compact('shops'));
    }

    // Show shop details
    public function showShop($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $shop = Shop::with('user')->findOrFail($id);
        $products = Product::where('shop_id', $id)->paginate(10);
        
        return view('admin.shops.show', compact('shop', 'products'));
    }

    // Manage product categories
    public function manageCategories()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $categories = ProductCategory::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    // Show category creation form
    public function createCategory()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        return view('admin.categories.create');
    }

    // Store new category
    public function storeCategory(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:product_categories',
            'description' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        ProductCategory::create([
            'category_name' => $request->category_name,
            'description' => $request->description,
            'created_on' => now(),
            'updated_on' => now(),
        ]);
        
        return redirect()->route('admin.categories')
                         ->with('success', 'Category created successfully');
    }

    // Show category edit form
    public function editCategory($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $category = ProductCategory::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Update category
    public function updateCategory(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $category = ProductCategory::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:product_categories,category_name,' . $id,
            'description' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $category->update([
            'category_name' => $request->category_name,
            'description' => $request->description,
            'updated_on' => now(),
        ]);
        
        return redirect()->route('admin.categories')
                         ->with('success', 'Category updated successfully');
    }

    // Delete category
    public function deleteCategory($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        
        return redirect()->route('admin.categories')
                         ->with('success', 'Category deleted successfully');
    }

    // Manage reports
    public function manageReports()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $reports = Report::with(['user', 'shop'])->latest()->paginate(15);
        return view('admin.reports.index', compact('reports'));
    }

    // Show report details
    public function showReport($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $report = Report::with(['user', 'shop'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    // Update report status
    public function updateReportStatus(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $report = Report::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,resolved,dismissed',
            'admin_notes' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $report->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => now(),
        ]);
        
        return redirect()->route('admin.reports')
                         ->with('success', 'Report status updated successfully');
    }

    // Manage discounts
    public function manageDiscounts()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $discounts = Discount::latest()->paginate(15);
        return view('admin.discounts.index', compact('discounts'));
    }

    // Show discount creation form
    public function createDiscount()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        return view('admin.discounts.create');
    }

    // Store new discount
    public function storeDiscount(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:discounts',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'required|integer|min:0',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        Discount::create($request->all());
        
        return redirect()->route('admin.discounts')
                         ->with('success', 'Discount created successfully');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
} 
