@extends('admin.layouts.app')

@section('title', 'Create Order')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">Create Order</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Create New Order</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf
                    
                    <!-- User Search -->
                    <div class="mb-4">
                        <label class="form-label">Search Customer (Email/Name)</label>
                        <div class="input-group">
                            <input type="text" id="user_search" class="form-control" placeholder="Type email or name...">
                            <button type="button" class="btn btn-outline-secondary" id="search_btn">Search</button>
                        </div>
                        <select name="user_id" id="user_id" class="form-select mt-2" size="3" style="display:none;" required>
                            <!-- Options added via JS -->
                        </select>
                        <small class="text-muted">Enter email or user name to search customer for making his order</small>
                    </div>

                    <!-- Package Selection -->
                    <div class="mb-3">
                        <label class="form-label">Select Package</label>
                        <select name="package_id" id="package_id" class="form-select" required>
                            <option value="">-- Select Package --</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" data-price="{{ $package->price }}">
                                    {{ $package->name }} - ${{ $package->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Adjustment -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Base Price</label>
                            <input type="text" id="base_price" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Add/Discount Amount</label>
                            <input type="number" name="adjustment_amount" id="adjustment_amount" class="form-control" step="0.01" value="0">
                            <small class="text-muted">Positive (e.g. 2 for +$2), Negative (e.g. -2 for -$2 discount)</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Total Price: <span id="total_price_display" class="text-success">$0.00</span></label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="order_status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const userSearchInput = document.getElementById('user_search');
    const searchBtn = document.getElementById('search_btn');
    const userSelect = document.getElementById('user_id');
    const packageSelect = document.getElementById('package_id');
    const basePriceInput = document.getElementById('base_price');
    const adjustmentInput = document.getElementById('adjustment_amount');
    const totalPriceDisplay = document.getElementById('total_price_display');

    // User Search Logic
    searchBtn.addEventListener('click', function() {
        const query = userSearchInput.value;
        if(query.length < 2) return;

        fetch('{{ route("admin.orders.search-user") }}?q=' + query)
            .then(res => res.json())
            .then(data => {
                userSelect.innerHTML = '';
                userSelect.style.display = 'block';
                if(data.length === 0) {
                    const opt = document.createElement('option');
                    opt.text = 'No users found';
                    userSelect.add(opt);
                } else {
                    data.forEach(user => {
                        const opt = document.createElement('option');
                        opt.value = user.id;
                        opt.text = `${user.name} (${user.email})`;
                        userSelect.add(opt);
                    });
                    userSelect.selectedIndex = 0; // Select first
                }
            });
    });

    // Price Calculation
    function updateTotal() {
        const price = parseFloat(packageSelect.selectedOptions[0]?.dataset.price || 0);
        const adj = parseFloat(adjustmentInput.value || 0);
        
        basePriceInput.value = price.toFixed(2);
        const total = price + adj;
        totalPriceDisplay.textContent = '$' + total.toFixed(2);
    }

    packageSelect.addEventListener('change', updateTotal);
    adjustmentInput.addEventListener('input', updateTotal);
</script>
@endpush
