@push('styles')
<style>
/* ══════════════════════════════════════════════════════════
   INNER PAGE HERO — Ultra Professional Cinematic Design
   ══════════════════════════════════════════════════════════ */

.pgH {
    position: relative;
    min-height: 52vh;
    display: flex;
    align-items: flex-start;
    overflow: hidden;
}

/* ── Background ── */
.pgH-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}

.pgH-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 30%;
    display: block;
}

/* Layered cinematic gradient */
.pgH-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(to right, rgba(6,8,18,0.97) 0%, rgba(6,8,18,0.85) 50%, rgba(6,8,18,0.55) 100%),
        linear-gradient(to top,   rgba(6,8,18,0.7)  0%, transparent 60%);
}

/* Animated grain overlay */
.pgH-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
    z-index: 1;
    pointer-events: none;
    opacity: 0.6;
}

/* Glow orbs */
.pgH-glow1 {
    position: absolute;
    bottom: -100px; left: -100px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,77,28,0.16) 0%, transparent 65%);
    z-index: 1; pointer-events: none;
}

.pgH-glow2 {
    position: absolute;
    top: -60px; right: 10%;
    width: 450px; height: 450px;
    background: radial-gradient(circle, rgba(99,102,241,0.07) 0%, transparent 65%);
    z-index: 1; pointer-events: none;
}

/* Bottom gradient fade */
.pgH-fade {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 120px;
    background: linear-gradient(to top, rgba(248,250,252,1) 0%, transparent 100%);
    z-index: 2;
    pointer-events: none;
}

/* Orange accent line at bottom */
.pgH-line {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent 0%, rgba(255,77,28,0.4) 20%, var(--primary) 50%, rgba(255,77,28,0.4) 80%, transparent 100%);
    z-index: 4;
}

/* ── Main Content ── */
.pgH-wrap {
    position: relative;
    z-index: 3;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 36px 24px 56px;
}

/* Two-column layout: text left, cards right */
.pgH-inner {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 60px;
    align-items: center;
}

/* ── LEFT: Text Column ── */
.pgH-left {}

/* Breadcrumb pill */
.pgH-crumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.74rem;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    margin-bottom: 20px;
    padding: 5px 14px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 999px;
    backdrop-filter: blur(6px);
    letter-spacing: 0.3px;
}

.pgH-crumb a {
    color: rgba(255,255,255,0.5);
    display: flex;
    align-items: center;
    gap: 4px;
    transition: color 0.2s;
}

.pgH-crumb a:hover { color: var(--primary); }
.pgH-crumb .sep { font-size: 0.65rem; color: rgba(255,255,255,0.2); }
.pgH-crumb .cur { color: var(--primary); font-weight: 800; }

/* Pulsing dot */
.pgH-dot {
    width: 6px; height: 6px;
    background: var(--primary);
    border-radius: 50%;
    animation: pgH-blink 2s ease-in-out infinite;
    flex-shrink: 0;
}

@keyframes pgH-blink {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: 0.4; transform: scale(1.8); }
}

/* Eyebrow badge */
.pgH-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 16px;
    background: rgba(255,77,28,0.15);
    border: 1px solid rgba(255,77,28,0.35);
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #ff8866;
    margin-bottom: 22px;
}

.pgH-badge i { font-size: 0.85rem; }

/* Main Title */
.pgH-title {
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 900;
    line-height: 1.06;
    letter-spacing: -1.5px;
    color: #fff;
    margin-bottom: 18px;
    text-shadow: 0 2px 30px rgba(0,0,0,0.4);
}

.pgH-title em {
    font-style: normal;
    color: var(--primary);
    position: relative;
}

/* Subtitle */
.pgH-sub {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.65);
    line-height: 1.78;
    max-width: 540px;
    margin-bottom: 16px;
}

/* Extra description */
.pgH-desc {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.38);
    line-height: 1.7;
    max-width: 520px;
    margin-bottom: 28px;
}

/* Feature highlights row */
.pgH-highlights {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 32px;
}

.pgH-hl-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    color: rgba(255,255,255,0.65);
}

.pgH-hl-ic {
    width: 26px; height: 26px;
    border-radius: 50%;
    background: rgba(255,77,28,0.15);
    border: 1px solid rgba(255,77,28,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 0.75rem;
    flex-shrink: 0;
}

/* CTA Row */
.pgH-cta {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 32px;
}

.pgH-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--primary) 0%, #e63e10 100%);
    color: #fff;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.9375rem;
    font-family: var(--font);
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 24px rgba(255,77,28,0.35);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}

.pgH-btn-primary::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s ease;
}

.pgH-btn-primary:hover::before { left: 100%; }

.pgH-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 36px rgba(255,77,28,0.45);
    color: #fff;
}

.pgH-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 26px;
    background: rgba(255,255,255,0.07);
    color: rgba(255,255,255,0.85);
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9375rem;
    font-family: var(--font);
    border: 1.5px solid rgba(255,255,255,0.2);
    transition: all 0.25s ease;
    backdrop-filter: blur(6px);
}

.pgH-btn-ghost:hover {
    background: rgba(255,255,255,0.13);
    border-color: rgba(255,255,255,0.35);
    color: #fff;
    transform: translateY(-2px);
}

/* Trust bar */
.pgH-trust {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

.pgH-avatars {
    display: flex;
}

.pgH-av {
    width: 32px; height: 32px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    font-weight: 800;
    color: #fff;
    margin-left: -8px;
    flex-shrink: 0;
}

.pgH-av:first-child { margin-left: 0; }

.pgH-trust-text { font-size: 0.78rem; color: rgba(255,255,255,0.5); }
.pgH-trust-text strong { color: rgba(255,255,255,0.85); font-weight: 800; }

.pgH-stars { display: flex; gap: 2px; color: #f59e0b; font-size: 0.7rem; margin-bottom: 2px; }

/* ── RIGHT: Info Cards ── */
.pgH-right {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

/* Stats grid card */
.pgH-stats-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 24px;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

.pgH-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.pgH-stat-item {
    text-align: center;
    padding: 14px 10px;
    background: rgba(255,255,255,0.05);
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.07);
    transition: all 0.22s ease;
}

.pgH-stat-item:hover {
    background: rgba(255,77,28,0.12);
    border-color: rgba(255,77,28,0.25);
}

.pgH-stat-num {
    font-size: 1.6rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
    letter-spacing: -0.5px;
}

.pgH-stat-num span { color: var(--primary); }

.pgH-stat-lbl {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: rgba(255,255,255,0.4);
    font-weight: 700;
}

/* Feature highlight card */
.pgH-feat-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 16px;
    padding: 20px;
    backdrop-filter: blur(10px);
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.pgH-feat-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.pgH-feat-row:last-child { border-bottom: none; }

.pgH-feat-ic {
    width: 34px; height: 34px;
    border-radius: 10px;
    background: rgba(255,77,28,0.12);
    border: 1px solid rgba(255,77,28,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 0.9rem;
    flex-shrink: 0;
}

.pgH-feat-txt strong {
    display: block;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.85);
    font-weight: 700;
    margin-bottom: 1px;
}

.pgH-feat-txt span {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.38);
}

/* ── Stats Strip at bottom (mobile) ── */
.pgH-strip {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 0;
}

.pgH-strip-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 999px;
    font-size: 0.77rem;
    font-weight: 700;
    color: rgba(255,255,255,0.65);
    backdrop-filter: blur(6px);
    transition: all 0.2s;
}

.pgH-strip-item:hover {
    background: rgba(255,77,28,0.12);
    border-color: rgba(255,77,28,0.25);
    color: #fff;
}

.pgH-strip-item i { color: var(--primary); font-size: 0.85rem; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .pgH { min-height: 48vh; }
    .pgH-wrap { padding: 30px 24px 48px; }
    .pgH-inner { grid-template-columns: 1fr; gap: 40px; }
    .pgH-right { flex-direction: row; flex-wrap: wrap; }
    .pgH-stats-card { flex: 1; min-width: 280px; }
    .pgH-feat-card { flex: 1; min-width: 280px; }
    .pgH-title { font-size: clamp(2.1rem, 5vw, 3.2rem); }
    .pgH-sub { max-width: 100%; }
}

@media (max-width: 768px) {
    .pgH { min-height: 42vh; }
    .pgH-wrap { padding: 24px 20px 44px; }
    .pgH-inner { gap: 30px; }
    .pgH-right { display: none; }
    .pgH-strip { display: flex; margin-top: 10px; }
    .pgH-title { font-size: clamp(2rem, 7vw, 2.8rem); letter-spacing: -1px; }
    .pgH-sub { font-size: 0.9375rem; }
    .pgH-desc { font-size: 0.875rem; }
    .pgH-highlights { gap: 8px; }
    .pgH-cta { gap: 10px; }
    .pgH-fade { display: none; }
}

@media (max-width: 480px) {
    .pgH { min-height: 36vh; }
    .pgH-wrap { padding: 18px 16px 36px; }
    .pgH-title { font-size: 1.85rem; }
    .pgH-btn-primary, .pgH-btn-ghost { padding: 12px 20px; font-size: 0.875rem; width: 100%; justify-content: center; }
    .pgH-trust { justify-content: center; }
    .pgH-strip-item { font-size: 0.72rem; padding: 5px 10px; }
}
</style>
@endpush

<section class="pgH">

    {{-- Background --}}
    <div class="pgH-bg">
        <img
            src="{{ $heroImage ?? '/page_hero_bg.png' }}"
            alt="{{ $title ?? 'Live IPTV Now' }}"
            loading="eager"
        >
    </div>

    {{-- Glows --}}
    <div class="pgH-glow1"></div>
    <div class="pgH-glow2"></div>

    {{-- Bottom fade into page --}}
    <div class="pgH-fade"></div>
    <div class="pgH-line"></div>

    {{-- Main Content --}}
    <div class="pgH-wrap">
        <div class="pgH-inner">

            {{-- ─── LEFT COLUMN ─── --}}
            <div class="pgH-left" data-aos="fade-right">

                {{-- Breadcrumb --}}
                <div class="pgH-crumb">
                    <span class="pgH-dot"></span>
                    <a href="{{ route('home') }}">
                        <i class="ri-home-4-line"></i> Live IPTV Now
                    </a>
                    <i class="ri-arrow-right-s-line sep"></i>
                    <span class="cur">{{ $breadcrumb ?? ($tag ?? 'Page') }}</span>
                </div>

                {{-- Title --}}
                <h1 class="pgH-title">
                    {{ $title ?? '' }}
                    @if(!empty($accent))
                    <br><em>{{ $accent }}</em>
                    @endif
                </h1>

                {{-- Subtitle --}}
                @if(!empty($subtitle))
                <p class="pgH-sub">{{ $subtitle }}</p>
                @endif

                {{-- Extra desc --}}
                @if(!empty($desc))
                <p class="pgH-desc">{{ $desc }}</p>
                @endif

                {{-- Highlight bullet points --}}
                @if(!empty($highlights))
                <div class="pgH-highlights">
                    @foreach($highlights as $h)
                    <div class="pgH-hl-item">
                        <div class="pgH-hl-ic"><i class="{{ $h['icon'] ?? 'ri-check-fill' }}"></i></div>
                        <span>{{ $h['text'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- CTA Buttons --}}
                @if(!empty($ctaPrimary) || !empty($ctaGhost))
                <div class="pgH-cta">
                    @if(!empty($ctaPrimary))
                    <a href="{{ $ctaPrimaryUrl ?? route('packages.index') }}" class="pgH-btn-primary">
                        <i class="{{ $ctaPrimaryIcon ?? 'ri-play-fill' }}"></i>
                        {{ $ctaPrimary }}
                    </a>
                    @endif
                    @if(!empty($ctaGhost))
                    <a href="{{ $ctaGhostUrl ?? route('contact') }}" class="pgH-btn-ghost">
                        <i class="{{ $ctaGhostIcon ?? 'ri-information-line' }}"></i>
                        {{ $ctaGhost }}
                    </a>
                    @endif
                </div>
                @endif

                {{-- Trust bar --}}
                <div class="pgH-trust">
                    <div class="pgH-avatars">
                        <div class="pgH-av" style="background:#6366f1;">MJ</div>
                        <div class="pgH-av" style="background:#8b5cf6;">SK</div>
                        <div class="pgH-av" style="background:#ec4899;">AL</div>
                        <div class="pgH-av" style="background:var(--primary);">RD</div>
                        <div class="pgH-av" style="background:#10b981;">+</div>
                    </div>
                    <div>
                        <div class="pgH-stars">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                        </div>
                        <div class="pgH-trust-text"><strong>100,000+</strong> happy customers worldwide</div>
                    </div>
                </div>

                {{-- mobile stats strip --}}
                @if(!empty($stats))
                <div class="pgH-strip" style="margin-top:24px;">
                    @foreach($stats as $s)
                    <div class="pgH-strip-item"><i class="{{ $s['icon'] }}"></i> {{ $s['text'] }}</div>
                    @endforeach
                </div>
                @endif

            </div>

            {{-- ─── RIGHT COLUMN ─── --}}
            <div class="pgH-right" data-aos="fade-left" data-aos-delay="100">

                {{-- Stats Grid Card --}}
                @if(!empty($stats))
                <div class="pgH-stats-card">
                    <div class="pgH-stats-grid">
                        @foreach(array_slice($stats, 0, 4) as $s)
                        <div class="pgH-stat-item">
                            <div class="pgH-stat-num">
                                <i class="{{ $s['icon'] }}" style="font-size:1.4rem;color:var(--primary);"></i>
                            </div>
                            <div class="pgH-stat-lbl">{{ $s['text'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="pgH-stats-card">
                    <div class="pgH-stats-grid">
                        <div class="pgH-stat-item">
                            <div class="pgH-stat-num">40K<span>+</span></div>
                            <div class="pgH-stat-lbl">Live Channels</div>
                        </div>
                        <div class="pgH-stat-item">
                            <div class="pgH-stat-num">4<span>K</span></div>
                            <div class="pgH-stat-lbl">Ultra HD</div>
                        </div>
                        <div class="pgH-stat-item">
                            <div class="pgH-stat-num">99<span>%</span></div>
                            <div class="pgH-stat-lbl">Uptime SLA</div>
                        </div>
                        <div class="pgH-stat-item">
                            <div class="pgH-stat-num">24<span>/7</span></div>
                            <div class="pgH-stat-lbl">Support</div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Feature highlights card --}}
                <div class="pgH-feat-card">
                    @if(!empty($highlights))
                        @foreach(array_slice($highlights, 0, 3) as $h)
                        <div class="pgH-feat-row">
                            <div class="pgH-feat-ic"><i class="{{ $h['icon'] ?? 'ri-check-fill' }}"></i></div>
                            <div class="pgH-feat-txt">
                                <strong>{{ $h['text'] }}</strong>
                                @if(!empty($h['sub']))<span>{{ $h['sub'] }}</span>@endif
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="pgH-feat-row">
                        <div class="pgH-feat-ic"><i class="ri-flashlight-fill"></i></div>
                        <div class="pgH-feat-txt">
                            <strong>Instant Activation</strong>
                            <span>Credentials in your inbox within minutes</span>
                        </div>
                    </div>
                    <div class="pgH-feat-row">
                        <div class="pgH-feat-ic"><i class="ri-device-line"></i></div>
                        <div class="pgH-feat-txt">
                            <strong>All Devices Supported</strong>
                            <span>Smart TV, Android, iOS, FireStick & more</span>
                        </div>
                    </div>
                    <div class="pgH-feat-row">
                        <div class="pgH-feat-ic"><i class="ri-shield-check-fill"></i></div>
                        <div class="pgH-feat-txt">
                            <strong>Money-Back Guarantee</strong>
                            <span>Not happy? Full refund within 24 hours</span>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>{{-- /pgH-inner --}}
    </div>{{-- /pgH-wrap --}}

</section>
