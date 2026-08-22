@extends('layouts.app')
@section('title', 'Order Confirmed - Live IPTV Now')

@section('content')
<section class="cx-result">
    <div class="wrap">
        <div class="cx-card" data-aos="fade-up">
            <div class="cx-icon ok"><i class="ri-checkbox-circle-fill"></i></div>
            <h1>Payment <i>Successful!</i></h1>
            <p>Your IPTV subscription is now active.</p>

            <div class="cx-details">
                <div class="cx-hdr"><span>Order #{{ $order->order_number }}</span><span>{{ $order->created_at->format('M d, Y - h:i A') }}</span></div>
                <div class="cx-item"><div class="cx-item-ic"><i class="ri-tv-2-fill"></i></div><div class="cx-item-info"><h4>{{ $order->package->name }}</h4><span>{{ $order->package->duration_label }} • {{ $order->package->devices }} {{ $order->package->devices > 1 ? 'Devices' : 'Device' }}</span></div><strong>${{ number_format($order->amount, 2) }}</strong></div>
                <div class="cx-row total"><span>Total Paid</span><strong style="color:var(--primary);font-size:1.2rem;">${{ number_format($order->amount, 2) }}</strong></div>
            </div>

            <div class="cx-email">
                <div class="cx-email-ic"><i class="ri-mail-fill"></i></div>
                <h3>Check Your Email!</h3>
                <p>Credentials sent to <strong>{{ $order->customer_email }}</strong></p>
                <div class="cx-checklist">
                    <div class="cx-chk"><i class="ri-checkbox-circle-fill"></i>Login credentials</div>
                    <div class="cx-chk"><i class="ri-checkbox-circle-fill"></i>Portal URL & M3U Playlist</div>
                    <div class="cx-chk"><i class="ri-checkbox-circle-fill"></i>Setup guide</div>
                    <div class="cx-chk"><i class="ri-checkbox-circle-fill"></i>Recommended apps</div>
                </div>
                <div class="cx-warn"><i class="ri-alert-line"></i><span><strong>Not received?</strong> Check spam/junk folder. Email <a href="mailto:info@liveiptvwlii.com" style="color:var(--primary);font-weight:800;">info@liveiptvwlii.com</a> if not received in 10 min.</span></div>
            </div>

            <div class="cx-steps">
                <h3><i class="ri-list-check-fill"></i> Next Steps</h3>
                <div class="cx-step"><span class="cx-sn">1</span><div><h4>Download an IPTV App</h4><p>IPTV Smarters, TiviMate, etc.</p></div></div>
                <div class="cx-step"><span class="cx-sn">2</span><div><h4>Enter Credentials</h4><p>Use the portal URL, username & password.</p></div></div>
                <div class="cx-step"><span class="cx-sn">3</span><div><h4>Start Watching</h4><p>Enjoy thousands of live channels.</p></div></div>
            </div>

            <div class="cx-actions"><a href="{{ route('home') }}" class="hb hb-b"><i class="ri-home-5-line"></i> Homepage</a><a href="{{ route('contact') }}" class="hb hb-g"><i class="ri-question-line"></i> Need Help?</a></div>
            <div class="cx-support"><i class="ri-headphone-fill"></i><div><span>Need setup help? 24/7 support</span><a href="mailto:info@liveiptvwlii.com">info@liveiptvwlii.com</a></div></div>
        </div>
    </div>
</section>

@push('styles')
<style>
.cx-result { padding: 180px 0 120px; min-height: 100vh; }
.cx-card { max-width: 640px; margin: 0 auto; background: var(--white); border: var(--bdr); border-radius: var(--r3); padding: 44px; text-align: center; box-shadow: var(--s3); }
.cx-icon { width: 88px; height: 88px; margin: 0 auto 24px; border-radius: 50%; display: grid; place-items: center; font-size: 3rem; animation: cxpop 0.5s ease forwards; }
@keyframes cxpop { 0% { transform: scale(0); opacity: 0; } 50% { transform: scale(1.15); } 100% { transform: scale(1); opacity: 1; } }
.cx-icon.ok { background: linear-gradient(135deg,#10b981,#059669); color: #fff; }
.cx-card h1 { font-size: 1.8rem; margin-bottom: 8px; }
.cx-card h1 i { font-family: var(--display); font-style: italic; font-weight: 400; }
.cx-card > p { color: var(--ink3); margin-bottom: 24px; }

.cx-details { background: var(--bg2); border-radius: var(--r2); padding: 18px; margin-bottom: 24px; text-align: left; }
.cx-hdr { display: flex; justify-content: space-between; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid rgba(0,0,0,0.04); }
.cx-hdr span { font-size: 0.82rem; }
.cx-hdr span:first-child { font-weight: 800; }
.cx-hdr span:last-child { color: var(--ink4); }
.cx-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.04); }
.cx-item-ic { width: 44px; height: 44px; background: linear-gradient(135deg,var(--primary),var(--primary-dark)); border-radius: 12px; display: grid; place-items: center; color: #fff; font-size: 1.2rem; }
.cx-item-info { flex: 1; }
.cx-item-info h4 { font-size: 0.95rem; margin-bottom: 2px; }
.cx-item-info span { font-size: 0.78rem; color: var(--ink4); }
.cx-row { display: flex; justify-content: space-between; padding: 10px 0 0; font-size: 0.9rem; }
.cx-row.total { border-top: 1px solid rgba(0,0,0,0.04); margin-top: 6px; padding-top: 12px; }

.cx-email { background: var(--bg2); border: var(--bdr); border-radius: var(--r2); padding: 28px; margin-bottom: 24px; color: var(--ink); }
.cx-email-ic { width: 64px; height: 64px; margin: 0 auto 14px; background: var(--primary-soft); border: 1px solid var(--primary-glow); color: var(--primary); border-radius: 50%; display: grid; place-items: center; font-size: 2rem; animation: cxpulse 2s ease-in-out infinite; }
@keyframes cxpulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
.cx-email h3 { margin-bottom: 8px; color: var(--ink); }
.cx-email > p { color: var(--ink4); margin-bottom: 18px; }
.cx-email strong { color: var(--primary); }
.cx-checklist { background: var(--bg3); border-radius: var(--r); padding: 14px; margin-bottom: 14px; text-align: left; }
.cx-chk { display: flex; align-items: center; gap: 8px; padding: 8px 0; font-size: 0.88rem; border-bottom: 1px solid var(--bg4); }
.cx-chk:last-child { border: none; }
.cx-chk i { color: var(--success); font-size: 1.1rem; }
.cx-warn { display: flex; align-items: flex-start; gap: 8px; padding: 10px; background: rgba(251,191,36,0.08); border: 1px solid rgba(251,191,36,0.2); border-radius: var(--r); text-align: left; font-size: 0.82rem; color: var(--ink3); }
.cx-warn i { color: #fbbf24; font-size: 1.1rem; flex-shrink: 0; }

.cx-steps { background: var(--bg2); border-radius: var(--r2); padding: 18px; margin-bottom: 24px; text-align: left; }
.cx-steps h3 { display: flex; align-items: center; gap: 6px; font-size: 1.05rem; margin-bottom: 14px; }
.cx-steps h3 i { color: var(--primary); }
.cx-step { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 10px; }
.cx-sn { width: 28px; height: 28px; background: linear-gradient(135deg,var(--primary),var(--primary-dark)); color: #fff; border-radius: 50%; display: grid; place-items: center; font-weight: 800; font-size: 0.78rem; flex-shrink: 0; }
.cx-step h4 { font-size: 0.92rem; margin-bottom: 2px; }
.cx-step p { font-size: 0.82rem; color: var(--ink4); }

.cx-actions { display: flex; gap: 10px; justify-content: center; margin-bottom: 18px; }
.hb-g { display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: transparent; color: var(--primary); border: 2px solid var(--primary); border-radius: var(--rr); font-weight: 800; font-size: 0.88rem; transition: var(--t); }
.hb-g:hover { background: var(--primary); color: #fff; }
.cx-support { display: flex; align-items: center; gap: 12px; padding: 14px 18px; background: var(--primary-soft); border-radius: var(--r); text-align: left; }
.cx-support i { font-size: 1.8rem; color: var(--primary); }
.cx-support span { display: block; font-size: 0.88rem; color: var(--ink3); margin-bottom: 2px; }
.cx-support a { font-weight: 800; color: var(--primary); font-size: 0.88rem; }

@media(max-width:768px) { .cx-result { padding: 140px 0 80px; } .cx-card { padding: 36px 24px; } .cx-card h1 { font-size: 1.5rem; } .cx-icon { width: 72px; height: 72px; font-size: 2.4rem; } .cx-email { padding: 22px; } }
@media(max-width:640px) { .cx-card { padding: 28px 16px; } .cx-actions { flex-direction: column; } .cx-hdr { flex-direction: column; gap: 4px; text-align: center; } .cx-support { flex-direction: column; text-align: center; } }
@media(max-width:480px) { .cx-result { padding: 120px 0 60px; } .cx-card h1 { font-size: 1.3rem; } .cx-icon { width: 64px; height: 64px; font-size: 2rem; } .cx-email { padding: 18px; } .cx-email-ic { width: 48px; height: 48px; font-size: 1.5rem; } .cx-details { padding: 14px; } .cx-steps { padding: 14px; } }
</style>
@endpush
@endsection
