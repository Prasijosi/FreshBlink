<div class="container">
    <h2>Welcome, Trader!</h2>

    @if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
    @endif

    <p>This is your dashboard. From here, you can manage your shop and products.</p>

    <a href="{{ route('shops.create') }}">Create another shop</a>
</div>


<div class="container">
    <h2>Your Shops</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($shops as $shop)
    <div class="card mb-2">
        <div class="card-body">
            <h5>{{ $shop->name }}</h5>
            <p>{{ $shop->description }}</p>
        </div>
    </div>
    @endforeach

    @if($shops->isEmpty())
    <p>You have no shops yet. <a href="{{ route('shops.create') }}">Create one now</a>.</p>
    @endif
</div>