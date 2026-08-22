@extends('layouts.app')
@section('title', 'Live TV Channels — Live IPTV Now | 40,000+ Channels')

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/hero_channels.png',
    'breadcrumb'     => 'Channels',
    'badge'          => 'Channel Guide — 150+ Countries',
    'badgeIcon'      => 'ri-tv-2-fill',
    'title'          => '40,000+ Live Channels',
    'accent'         => 'Worldwide',
    'subtitle'       => 'Sports, movies, news, kids & entertainment from 150+ countries — all streaming in crystal-clear HD & 4K with zero buffering.',
    'desc'           => 'From Premier League football to Hollywood blockbusters, breaking news to kids cartoons — everything you love, all in one place. Instant access, no contracts.',
    'highlights' => [
        ['icon' => 'ri-football-fill',  'text' => 'Live Sports — Premier League, NFL, NBA, UFC & PPV events', 'sub' => '2,500+ sports channels from top networks'],
        ['icon' => 'ri-movie-2-fill',  'text' => '100,000+ Movies & TV Series on demand',                   'sub' => 'Latest blockbusters in HD & 4K quality'],
        ['icon' => 'ri-globe-fill',    'text' => 'International Channels from 150+ countries',              'sub' => 'Arabic, India, UK, Europe, Latin America & more'],
    ],
    'ctaPrimary'     => 'Start Watching Now',
    'ctaPrimaryUrl'  => route('packages.index'),
    'ctaPrimaryIcon' => 'ri-play-fill',
    'ctaGhost'       => 'Free Trial',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-gift-line',
    'stats' => [
        ['icon' => 'ri-tv-2-fill',        'text' => '40,000+ Live Channels'],
        ['icon' => 'ri-global-fill',      'text' => '150+ Countries'],
        ['icon' => 'ri-movie-2-fill',     'text' => '100K+ VOD Library'],
        ['icon' => 'ri-4k-fill',          'text' => 'HD & 4K Quality'],
        ['icon' => 'ri-football-fill',    'text' => 'Live Sports PPV'],
    ],
])

{{-- Category Filter --}}
<div class="ch-filter-bar">
    <div class="wrap">
        <div class="ch-tabs" data-aos="fade-up">
            <button class="ch-tab on" data-category="all"><i class="ri-grid-fill"></i> All</button>
            <button class="ch-tab" data-category="sports"><i class="ri-football-line"></i> Sports</button>
            <button class="ch-tab" data-category="movies"><i class="ri-clapperboard-line"></i> Movies</button>
            <button class="ch-tab" data-category="news"><i class="ri-newspaper-line"></i> News</button>
            <button class="ch-tab" data-category="entertainment"><i class="ri-star-line"></i> Entertainment</button>
            <button class="ch-tab" data-category="kids"><i class="ri-bear-smile-fill"></i> Kids</button>
            <button class="ch-tab" data-category="documentary"><i class="ri-global-line"></i> Documentary</button>
        </div>
    </div>
</div>

{{-- Channel Category Cards --}}
<section class="ch-sec">
    <div class="wrap">
        <div class="ch-grid">
            @foreach([
                ['sports',       'ri-football-fill',      'Sports Channels',     '2,500+', ['ESPN','beIN Sports','Sky Sports','FOX Sports','NBC Sports'], '+500',  ['Premier League & La Liga','NFL, NBA, MLB & NHL','UFC, Boxing, Wrestling','Live PPV Events']],
                ['movies',       'ri-clapperboard-fill',  'Movies & Series',     '50,000+',['HBO','Netflix','AMC','Showtime','FX'],                       '+1000', ['Latest Hollywood Blockbusters','Complete TV Series','4K Ultra HD Quality','Multi-language Subtitles']],
                ['news',         'ri-newspaper-fill',     'News Channels',       '800+',   ['CNN','BBC World','Al Jazeera','Fox News','MSNBC'],            '+200',  ['24/7 Live Coverage','Global News Networks','Business & Finance','Local & Regional News']],
                ['entertainment','ri-star-fill',          'Entertainment',       '5,000+', ['E!','MTV','Comedy Central','TLC','Bravo'],                   '+1500', ['Reality & Talk Shows','Music & Concerts','Lifestyle & Travel','Award Shows Live']],
                ['kids',         'ri-bear-smile-fill',    'Kids & Family',       '1,000+', ['Disney','Nickelodeon','Cartoon Network','PBS','BabyTV'],      '+300',  ['Family-Friendly Content','Educational Programs','Cartoons & Animation','Safe for All Ages']],
                ['documentary',  'ri-global-fill',        'Documentary',         '600+',   ['Discovery','Nat Geo','History','Animal Planet','Science'],    '+100',  ['Nature & Wildlife','History & Science','True Crime Stories','Travel & Adventure']],
            ] as $cat)
            <div class="ch-card" data-category="{{ $cat[0] }}" data-aos="fade-up">
                <div class="ch-card-head">
                    <div class="ch-ic {{ $cat[0] }}"><i class="{{ $cat[1] }}"></i></div>
                    <div>
                        <h3>{{ $cat[2] }}</h3>
                        <span>{{ $cat[3] }} channels</span>
                    </div>
                    <div class="ch-count">{{ $cat[5] }}</div>
                </div>
                <div class="ch-logos">
                    @foreach($cat[4] as $l)<span class="ch-logo">{{ $l }}</span>@endforeach
                </div>
                <ul class="ch-feat">
                    @foreach($cat[6] as $f)
                    <li><i class="ri-check-fill"></i>{{ $f }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('packages.index') }}" class="ch-cta">
                    Get Access <i class="ri-arrow-right-line"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Full Channel Lineup --}}
<section class="ch-lineup-sec">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <h2 class="sec-h" style="color:var(--ink);">Complete Channel <em style="color:var(--primary);font-style:normal;">Lineup</em></h2>
            <p class="sec-d">Search and browse our full catalogue of 40,000+ channels.</p>
        </div>
        <div class="ch-lineup-box" data-aos="fade-up">
            <div class="ch-lineup-controls">
                <div class="ch-lu-search">
                    <i class="ri-search-line"></i>
                    <input type="text" id="lineupSearch" placeholder="Search channels...">
                </div>
                <div class="ch-lu-pills">
                    <button class="ch-pill on" data-filter="all">All</button>
                    <button class="ch-pill" data-filter="Sports">Sports</button>
                    <button class="ch-pill" data-filter="Movies">Movies</button>
                    <button class="ch-pill" data-filter="News">News</button>
                    <button class="ch-pill" data-filter="Kids">Kids</button>
                    <button class="ch-pill" data-filter="Adult">Adult 18+</button>
                </div>
            </div>
            <div class="ch-lu-grid" id="channelsGrid">
                <div class="ch-lu-loader"><div class="ch-lu-spin"></div> Loading channels...</div>
            </div>
            <div style="text-align:center;margin-top:24px;">
                <button id="loadMoreBtn" class="btn btn-outline">
                    Load More <span id="showingCount" style="opacity:0.5;margin-left:6px;">(0 of 20K+)</span>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- Countries Coverage --}}
<section class="ch-countries-sec">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <h2 class="sec-h" style="color:var(--ink);">Worldwide <em style="color:var(--primary);font-style:normal;">Coverage</em></h2>
            <p class="sec-d">Access channels from 150+ countries around the globe.</p>
        </div>
        <div class="co-grid" data-aos="fade-up">
            @foreach([['🇺🇸','USA','3,000+'],['🇬🇧','UK','2,000+'],['🇨🇦','Canada','1,500+'],['🇩🇪','Germany','1,000+'],['🇫🇷','France','1,000+'],['🇪🇸','Spain','800+'],['🇮🇹','Italy','800+'],['🇳🇱','Netherlands','600+'],['🇧🇷','Brazil','1,000+'],['🇸🇦','Arabic','2,000+'],['🇮🇳','India','1,500+'],['🇹🇷','Turkey','800+'],['🇵🇰','Pakistan','600+'],['🇦🇫','Afghan','300+']] as $c)
            <div class="co-card">
                <span class="co-flag">{{ $c[0] }}</span>
                <span class="co-name">{{ $c[1] }}</span>
                <span class="co-cnt">{{ $c[2] }}</span>
            </div>
            @endforeach
            <div class="co-card accent">
                <span class="co-flag">🌍</span>
                <span class="co-name">135+ More</span>
                <span class="co-cnt">Countries</span>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="wrap cta-inner">
        <h2>Start Watching <em style="font-style:normal;color:rgba(255,255,255,0.85);">Today</em></h2>
        <p>Instant access to 40,000+ live channels. No buffering. No contracts.</p>
        <div class="cta-btns">
            <a href="{{ route('packages.index') }}" class="btn btn-white btn-lg"><i class="ri-play-fill"></i> View Plans</a>
            <a href="{{ route('contact') }}" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.3);">Free Trial</a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Filter Bar ── */
.ch-filter-bar {
    background: #fff;
    border-bottom: var(--bdr);
    padding: 16px 0;
    position: sticky;
    top: 75px;
    z-index: 100;
    box-shadow: var(--s1);
}
.ch-tabs { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
.ch-tab {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px;
    font-size: 0.85rem; font-weight: 700;
    color: var(--ink4);
    border-radius: var(--rr);
    border: 1.5px solid transparent;
    background: var(--bg2);
    cursor: pointer; transition: var(--t);
    font-family: var(--font);
}
.ch-tab:hover { color: var(--primary); background: var(--primary-soft); border-color: var(--primary-glow); }
.ch-tab.on { background: var(--primary); color: #fff; border-color: var(--primary); }

/* ── Section ── */
.ch-sec { padding: 60px 0; }

/* ── Channel Cards ── */
.ch-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}
.ch-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 18px;
    padding: 28px 24px;
    transition: var(--ts);
    display: flex;
    flex-direction: column;
    gap: 18px;
    box-shadow: var(--s1);
    position: relative;
    overflow: hidden;
}
.ch-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--primary);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.ch-card:hover { transform: translateY(-7px); box-shadow: var(--s4); border-color: rgba(255,77,28,0.2); }
.ch-card:hover::before { transform: scaleX(1); }

.ch-card-head { display: flex; align-items: center; gap: 14px; }
.ch-ic {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: grid; place-items: center;
    font-size: 1.4rem; color: var(--primary);
    flex-shrink: 0; transition: var(--t);
}
.ch-ic.sports        { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2); color: #ef4444; }
.ch-ic.movies        { background: rgba(139,92,246,0.1); border-color: rgba(139,92,246,0.2); color: #8b5cf6; }
.ch-ic.news          { background: rgba(59,130,246,0.1); border-color: rgba(59,130,246,0.2); color: #3b82f6; }
.ch-ic.entertainment { background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.2); color: #f59e0b; }
.ch-ic.kids          { background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2); color: #10b981; }
.ch-ic.documentary   { background: rgba(14,165,233,0.1); border-color: rgba(14,165,233,0.2); color: #0ea5e9; }
.ch-card:hover .ch-ic { background: var(--primary); border-color: var(--primary); color: #fff; }

.ch-card-head h3 { font-size: 1.1rem; color: var(--ink); margin-bottom: 2px; }
.ch-card-head > div:nth-child(2) span { font-size: 0.75rem; color: var(--ink5); font-weight: 600; }
.ch-count {
    margin-left: auto;
    background: var(--primary-soft);
    color: var(--primary);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 900;
    border: 1px solid var(--primary-glow);
    flex-shrink: 0;
}

.ch-logos { display: flex; flex-wrap: wrap; gap: 6px; }
.ch-logo {
    padding: 4px 10px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 6px;
    font-size: 0.74rem;
    font-weight: 700;
    color: var(--ink3);
}

.ch-feat { display: flex; flex-direction: column; gap: 8px; flex: 1; }
.ch-feat li {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.86rem; color: var(--ink3);
}
.ch-feat i { color: var(--success); font-size: 1rem; width: 18px; flex-shrink: 0; }

.ch-cta {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 0.88rem; font-weight: 800;
    color: var(--primary);
    margin-top: 4px;
    transition: var(--t);
}
.ch-cta:hover { gap: 12px; }

/* ── Lineup Section ── */
.ch-lineup-sec { background: var(--bg2); padding: 80px 0; border-top: var(--bdr); }
.ch-lineup-box {
    background: #fff;
    border: var(--bdr);
    border-radius: 20px;
    padding: 36px;
    box-shadow: var(--s2);
}
.ch-lineup-controls {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}
.ch-lu-search {
    width: 100%; max-width: 520px;
    position: relative;
}
.ch-lu-search i {
    position: absolute; left: 16px; top: 50%;
    transform: translateY(-50%);
    color: var(--ink5); font-size: 1.1rem;
}
.ch-lu-search input {
    width: 100%; padding: 13px 18px 13px 46px;
    border: 1.5px solid #e5e7eb;
    border-radius: var(--r2);
    font-family: var(--font); font-size: 0.95rem;
    color: var(--ink);
    transition: var(--t); outline: none;
    background: var(--bg2);
}
.ch-lu-search input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px var(--primary-glow); }

.ch-lu-pills { display: flex; flex-wrap: wrap; justify-content: center; gap: 6px; }
.ch-pill {
    padding: 7px 18px;
    border: 1.5px solid #e5e7eb;
    border-radius: var(--rr);
    background: var(--bg2);
    cursor: pointer; font-family: var(--font);
    font-size: 0.82rem; font-weight: 700;
    color: var(--ink4); transition: var(--t);
}
.ch-pill:hover { border-color: var(--primary); color: var(--primary); }
.ch-pill.on { background: var(--primary); color: #fff; border-color: var(--primary); }

.ch-lu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px,1fr));
    gap: 8px;
}
.channel-item {
    padding: 10px 14px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 10px;
    font-size: 0.85rem; font-weight: 600;
    color: var(--ink3);
    display: flex; align-items: center; gap: 8px;
    transition: var(--t);
}
.channel-item i { color: var(--ink5); }
.channel-item:hover { border-color: var(--primary); background: var(--primary-soft); color: var(--primary); }
.channel-item:hover i { color: var(--primary); }

.ch-lu-loader { text-align: center; padding: 40px; color: var(--ink4); font-weight: 600; grid-column: 1/-1; }
.ch-lu-spin {
    display: inline-block; width: 20px; height: 20px;
    border: 3px solid var(--bg4);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    margin-right: 8px;
    vertical-align: middle;
}

/* ── Countries ── */
.ch-countries-sec { padding: 80px 0; }
.co-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(110px,1fr));
    gap: 12px;
}
.co-card {
    display: flex; flex-direction: column; align-items: center;
    padding: 20px 12px;
    background: #fff;
    border: var(--bdr);
    border-radius: 14px;
    transition: var(--ts);
    text-align: center;
}
.co-card:hover { transform: translateY(-5px); box-shadow: var(--s3); border-color: var(--primary-glow); }
.co-flag { font-size: 2rem; margin-bottom: 8px; }
.co-name { font-size: 0.85rem; font-weight: 800; color: var(--ink2); margin-bottom: 2px; }
.co-cnt { font-size: 0.72rem; color: var(--ink5); font-weight: 600; }
.co-card.accent { background: var(--primary); border-color: var(--primary); }
.co-card.accent .co-name,
.co-card.accent .co-cnt { color: rgba(255,255,255,0.9); }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .ch-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 768px) {
    .ch-filter-bar { top: 68px; }
    .ch-tabs { justify-content: flex-start; overflow-x: auto; flex-wrap: nowrap; padding-bottom: 4px; }
    .ch-tab { flex-shrink: 0; font-size: 0.8rem; padding: 8px 14px; }
    .ch-grid { grid-template-columns: 1fr; }
    .ch-lineup-box { padding: 24px 18px; }
    .co-grid { grid-template-columns: repeat(3,1fr); }
}
@media (max-width: 480px) {
    .co-grid { grid-template-columns: repeat(2,1fr); }
    .ch-lu-grid { grid-template-columns: repeat(auto-fill, minmax(140px,1fr)); }
}
</style>
@endpush

@push('scripts')
<script>
// Category filter
document.querySelectorAll('.ch-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.ch-tab').forEach(t => t.classList.remove('on'));
        this.classList.add('on');
        const cat = this.dataset.category;
        document.querySelectorAll('.ch-card').forEach(card => {
            const show = cat === 'all' || card.dataset.category === cat;
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            if (show) {
                card.style.display = 'flex';
                setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 10);
            } else {
                card.style.opacity = '0'; card.style.transform = 'translateY(12px)';
                setTimeout(() => { card.style.display = 'none'; }, 300);
            }
        });
    });
});

// Full lineup
document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('channelsGrid');
    const lb   = document.getElementById('loadMoreBtn');
    const si   = document.getElementById('lineupSearch');
    const cnt  = document.getElementById('showingCount');
    const pills = document.querySelectorAll('.ch-pill');
    let all = [], dc = 0, cf = 'all', sq = '';
    const CS = 120;

    function gen() {
        const cats = {
            Sports: ['ESPN','Fox Sports','Sky Sports','beIN Sports','Eurosport','BT Sport','NBC Sports','LaLiga TV','Premier Sports'],
            Movies: ['HBO','Sky Cinema','Starz','Showtime','Cinemax','AMC','TCM','Paramount','MGM'],
            News: ['CNN','BBC News','Fox News','Al Jazeera','MSNBC','CNBC','Sky News','Bloomberg','Reuters TV'],
            Kids: ['Disney Channel','Nickelodeon','Cartoon Network','Boomerang','PBS Kids','BabyTV','Sprout'],
            Adult: ['Adult Channel'],
            Entertainment: ['E!','MTV','Comedy Central','TLC','Bravo','Discovery','History','Lifetime']
        };
        const l = [];
        Object.keys(cats).forEach(c => {
            cats[c].forEach(p => {
                ['','HD','FHD','4K'].forEach(q => l.push({ name: `${p}${q ? ' '+q : ''}`, category: c }));
                for (let i = 1; i <= 10; i++) l.push({ name: `${p} ${i} HD`, category: c });
            });
            for (let i = 1; i <= 100; i++) l.push({ name: `${c} Network ${i}`, category: c });
        });
        ['USA','UK','DE','FR','IT','ES','TR','AR','IN','PK'].forEach(code => {
            for (let i = 1; i <= 80; i++) l.push({ name: `Local ${code} Channel ${i}`, category: 'News' });
        });
        return l.sort(() => Math.random() - 0.5);
    }

    all = gen();

    function render(append = false) {
        if (!append) { grid.innerHTML = ''; dc = 0; }
        const f = all.filter(ch => (cf === 'all' || ch.category === cf) && ch.name.toLowerCase().includes(sq.toLowerCase()));
        const s = f.slice(dc, dc + CS);
        if (!s.length && !append) {
            grid.innerHTML = '<div class="ch-lu-loader">No channels found.</div>';
            lb.style.display = 'none'; return;
        }
        s.forEach(ch => {
            const d = document.createElement('div');
            d.className = 'channel-item';
            d.innerHTML = `<i class="ri-tv-2-fill"></i>${ch.name}`;
            grid.appendChild(d);
        });
        dc += s.length;
        cnt.textContent = `(${dc} of ${f.length.toLocaleString()})`;
        lb.style.display = dc >= f.length ? 'none' : 'inline-flex';
    }

    render();
    lb.addEventListener('click', () => render(true));
    si.addEventListener('input', e => { sq = e.target.value; render(false); });
    pills.forEach(p => p.addEventListener('click', () => {
        pills.forEach(x => x.classList.remove('on'));
        p.classList.add('on');
        cf = p.dataset.filter;
        render(false);
    }));
});
</script>
@endpush
