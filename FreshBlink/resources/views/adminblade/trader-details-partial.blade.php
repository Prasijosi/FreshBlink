<div class="row">
    <div class="col-md-6">
        <h5>Basic Information</h5>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $trader->user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $trader->user->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $trader->user->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Trader Type</th>
                <td>{{ $trader->trader_type_display }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge badge-{{ $trader->trader_status === 'approved' ? 'success' : ($trader->trader_status === 'rejected' ? 'danger' : 'warning') }}">
                        {{ ucfirst($trader->trader_status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Registered On</th>
                <td>{{ $trader->created_at->format('M d, Y H:i') }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h5>Statistics</h5>
        <table class="table table-bordered">
            <tr>
                <th>Total Shops</th>
                <td>{{ $trader->shops->count() }}</td>
            </tr>
            <tr>
                <th>Total Products</th>
                <td>{{ $trader->products->count() }}</td>
            </tr>
            <tr>
                <th>Total Orders</th>
                <td>{{ $trader->orders->count() }}</td>
            </tr>
            <tr>
                <th>Total Sales</th>
                <td>${{ number_format($trader->orders->sum('total_amount'), 2) }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <h5>Recent Products</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trader->products->take(3) as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <h5>Recent Orders</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trader->orders->take(3) as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($trader->trader_status === 'pending')
    <div class="row mt-3">
        <div class="col-12">
            <h5>Actions</h5>
            <form action="{{ route('admin.traders.approve', $trader->user_id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-check"></i> Approve Trader
                </button>
            </form>
            <form action="{{ route('admin.traders.reject', $trader->user_id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-times"></i> Reject Trader
                </button>
            </form>
        </div>
    </div>
@endif