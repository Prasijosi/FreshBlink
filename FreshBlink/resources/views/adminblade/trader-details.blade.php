@extends('adminblade.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Trader Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.traders') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $trader->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $trader->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $trader->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Trader Type</th>
                                    <td>{{ ucfirst($trader->trader_type) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $trader->status === 'approved' ? 'success' : ($trader->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($trader->status) }}
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
                            <h4>Statistics</h4>
                            <table class="table table-bordered">
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

                    @if($trader->status === 'pending')
                        <div class="row mt-4">
                            <div class="col-12">
                                <h4>Actions</h4>
                                <button type="button" class="btn btn-success" 
                                        onclick="confirmAction('{{ route('admin.traders.approve', $trader->id) }}', 'approve')">
                                    <i class="fas fa-check"></i> Approve Trader
                                </button>
                                <button type="button" class="btn btn-danger" 
                                        onclick="confirmAction('{{ route('admin.traders.reject', $trader->id) }}', 'reject')">
                                    <i class="fas fa-times"></i> Reject Trader
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Recent Products</h4>
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
                                        @forelse($trader->products->take(5) as $product)
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

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Recent Orders</h4>
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
                                        @forelse($trader->orders->take(5) as $order)
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <span id="actionType"></span> this trader?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="actionForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmAction(url, action) {
    $('#actionType').text(action);
    $('#actionForm').attr('action', url);
    $('#confirmationModal').modal('show');
}
</script>
@endpush 