

@section('content')
<div class="container">
    <h2>Create a Shop</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('shops.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Shop Name:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div style="color: red;">{{ $message }}</div> @enderror
        </div><br>

        <div>
            <label for="description">Description (optional):</label><br>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
            @error('description') <div style="color: red;">{{ $message }}</div> @enderror
        </div><br>

        <button type="submit">Create Shop</button>
    </form>
</div>
