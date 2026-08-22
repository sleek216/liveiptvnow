@extends('admin.layouts.app')

@section('title', 'Affiliate Settings')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Affiliate Settings</h1>
                    <p class="text-muted mb-0">Configure your affiliate program parameters</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.affiliate.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Enable/Disable -->
                        <div class="mb-4 pb-4 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Program Status</h5>
                                    <p class="text-muted small mb-0">Enable or disable the affiliate program globally</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="affiliate_enabled" name="affiliate_enabled" value="1" {{ \App\Models\Setting::get('affiliate_enabled', true) ? 'checked' : '' }} style="width: 3em; height: 1.5em; cursor: pointer;">
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <!-- Commission Rate -->
                            <div class="col-md-12">
                                <label for="affiliate_commission_rate" class="form-label fw-bold">Commission Rate (%)</label>
                                <div class="input-group">
                                    <input type="number" name="affiliate_commission_rate" id="affiliate_commission_rate" 
                                        class="form-control" 
                                        placeholder="20" 
                                        value="{{ \App\Models\Setting::get('affiliate_commission_rate', 20) }}"
                                        min="0" max="100" step="0.1">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text">Percentage of sale amount given to affiliate</div>
                            </div>

                            <!-- Minimum Payout -->
                            <div class="col-md-6">
                                <label for="affiliate_minimum_payout" class="form-label fw-bold">Minimum Payout Amount ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="affiliate_minimum_payout" id="affiliate_minimum_payout" 
                                        class="form-control" 
                                        placeholder="50" 
                                        value="{{ \App\Models\Setting::get('affiliate_minimum_payout', 50) }}"
                                        min="0" step="0.01">
                                </div>
                                <div class="form-text">Minimum earnings required before payout request</div>
                            </div>

                            <!-- Cookie Duration -->
                            <div class="col-md-6">
                                <label for="affiliate_cookie_duration" class="form-label fw-bold">Cookie Duration (Days)</label>
                                <div class="input-group">
                                    <input type="number" name="affiliate_cookie_duration" id="affiliate_cookie_duration" 
                                        class="form-control" 
                                        placeholder="30" 
                                        value="{{ \App\Models\Setting::get('affiliate_cookie_duration', 30) }}"
                                        min="1" max="365" step="1">
                                    <span class="input-group-text">Days</span>
                                </div>
                                <div class="form-text">How long referral tracking cookie remains valid</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-check-lg me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
