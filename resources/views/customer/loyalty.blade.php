@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Your Loyalty Points</h2>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="points-summary">
                        <div class="points-balance">
                            <h3>Current Points Balance</h3>
                            <p class="points">{{ number_format($customer->loyalty_points) }}</p>
                        </div>

                        <div class="available-discount">
                            <h3>Available Discount</h3>
                            <p class="discount">Rs. {{ number_format($availableDiscount, 2) }}</p>
                        </div>
                    </div>

                    @if($customer->loyalty_points >= 500)
                        <div class="redeem-points">
                            <h3>Redeem Points</h3>
                            <form method="POST" action="{{ route('customer.redeem-points') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="points_to_redeem">Points to Redeem</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="points_to_redeem" 
                                           name="points_to_redeem" 
                                           min="500" 
                                           max="{{ $customer->loyalty_points }}" 
                                           step="100" 
                                           required>
                                    <small class="form-text text-muted">
                                        Minimum redemption: 500 points<br>
                                        100 points = Rs. 1 discount
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary">Apply Points to Next Order</button>
                            </form>
                        </div>
                    @else
                        <div class="points-info">
                            <p>You need at least 500 points to redeem for a discount.</p>
                            <p>Keep shopping to earn more points!</p>
                        </div>
                    @endif

                    <div class="points-history mt-4">
                        <h3>Points History</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Points Earned</th>
                                        <th>Points Redeemed</th>
                                        <th>Order Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->user->orders()->latest()->take(5)->get() as $order)
                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>+{{ $order->points_earned }}</td>
                                            <td>{{ $order->points_redeemed > 0 ? "-{$order->points_redeemed}" : '-' }}</td>
                                            <td>Rs. {{ number_format($order->total_order, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="points-info mt-4">
                        <h3>How to Earn Points</h3>
                        <ul>
                            <li>Earn 1 point for every Rs. 10 spent</li>
                            <li>Points are awarded after order completion</li>
                            <li>Points expire after 12 months</li>
                            <li>Minimum redemption: 500 points</li>
                            <li>100 points = Rs. 1 discount</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.points-summary {
    display: flex;
    justify-content: space-around;
    margin-bottom: 2rem;
    text-align: center;
}

.points-balance, .available-discount {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    min-width: 200px;
}

.points, .discount {
    font-size: 2rem;
    font-weight: bold;
    color: #28a745;
    margin: 0;
}

.redeem-points {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.points-info ul {
    list-style-type: none;
    padding-left: 0;
}

.points-info ul li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.points-info ul li:last-child {
    border-bottom: none;
}
</style>
@endsection 