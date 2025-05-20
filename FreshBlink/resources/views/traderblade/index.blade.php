 


<div class="container">
    <h2 class="mb-4">My Products</h2>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Shop</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Stock No</th>
                <th>Min/Max Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->shop->name ?? 'N/A' }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->stock_no }}</td>
                <td>{{ $product->min_order }} / {{ $product->max_order ?? '-' }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8">No products found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
