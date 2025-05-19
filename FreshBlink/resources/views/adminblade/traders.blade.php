@extends('adminblade.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Trader Approval Panel</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                Filter by Status
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.traders') }}">All</a>
                                <a class="dropdown-item" href="{{ route('admin.traders', ['status' => 'pending']) }}">Pending</a>
                                <a class="dropdown-item" href="{{ route('admin.traders', ['status' => 'approved']) }}">Approved</a>
                                <a class="dropdown-item" href="{{ route('admin.traders', ['status' => 'rejected']) }}">Rejected</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Trader Type</th>
                                    <th>Status</th>
                                    <th>Registered On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($traders as $trader)
                                    <tr>
                                        <td>{{ $trader->name }}</td>
                                        <td>{{ $trader->email }}</td>
                                        <td>{{ $trader->phone }}</td>
                                        <td>{{ ucfirst($trader->trader_type) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $trader->status === 'approved' ? 'success' : ($trader->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($trader->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $trader->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            @if($trader->status === 'pending')
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        onclick="confirmAction('{{ route('admin.traders.approve', $trader->id) }}', 'approve')">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="confirmAction('{{ route('admin.traders.reject', $trader->id) }}', 'reject')">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-info btn-sm" 
                                                        onclick="viewTraderDetails({{ $trader->id }})">
                                                    <i class="fas fa-eye"></i> View Details
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No traders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $traders->links() }}
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

<!-- Trader Details Modal -->
<div class="modal fade" id="traderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="traderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="traderDetailsModalLabel">Trader Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="traderDetailsContent">
                Loading...
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

function viewTraderDetails(traderId) {
    $('#traderDetailsContent').html('Loading...');
    $('#traderDetailsModal').modal('show');
    
    // Load trader details via AJAX
    $.get(`/admin/traders/${traderId}/details`, function(data) {
        $('#traderDetailsContent').html(data);
    });
}
</script>
@endpush
