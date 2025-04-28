<h2>Trader Approval Panel</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Status</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($traders as $trader)
            <tr>
                <td>{{ $trader->name }}</td>
                <td>{{ $trader->email }}</td>
                <td>{{ $trader->status }}</td>
                <td>
                    @if($trader->status === 'pending')
                        <form action="{{ url('/admin/traders/'.$trader->id.'/approve') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                        <form action="{{ url('/admin/traders/'.$trader->id.'/reject') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Reject</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
