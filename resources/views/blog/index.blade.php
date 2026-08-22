@extends('layouts.app')
@section('title', 'Blog — IPTV News, Tutorials & Updates | Live IPTV Now')

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/hero_blog.png',
    'breadcrumb'     => 'Blog',
    'badge'          => 'IPTV Blog — Expert Knowledge Hub',
    'badgeIcon'      => 'ri-article-fill',
    'title'          => 'Expert Tips, News',
    'accent'         => '& Tutorials',
    'subtitle'       => 'Stay ahead with the latest IPTV industry insights, step-by-step setup guides, and expert streaming tips written by our tech team.',
    'desc'           => 'From beginner setup guides to advanced optimization tips — our blog covers everything you need to get the most out of your IPTV subscription.',
    'highlights' => [
        ['icon' => 'ri-graduation-cap-fill', 'text' => 'Step-by-Step Setup Guides for all devices',  'sub' => 'FireStick, Smart TV, Android, iOS & more'],
        ['icon' => 'ri-lightbulb-fill',      'text' => 'Pro Streaming Tips to eliminate buffering',  'sub' => 'Network, VPN, quality & performance tips'],
        ['icon' => 'ri-notification-fill',   'text' => 'Weekly updates on new channels & features',  'sub' => 'Stay informed on the latest additions'],
    ],
    'ctaPrimary'     => 'Browse Articles',
    'ctaPrimaryUrl'  => '#blog-posts',
    'ctaPrimaryIcon' => 'ri-article-line',
    'ctaGhost'       => 'Get IPTV Plan',
    'ctaGhostUrl'    => route('packages.index'),
    'ctaGhostIcon'   => 'ri-play-circle-line',
    'stats' => [
        ['icon' => 'ri-article-fill',        'text' => '50+ Articles Published'],
        ['icon' => 'ri-graduation-cap-fill', 'text' => 'Setup Guides'],
        ['icon' => 'ri-lightbulb-fill',      'text' => 'Pro Tips & Tricks'],
        ['icon' => 'ri-notification-fill',   'text' => 'Weekly Updates'],
    ],
])

{{-- Category Filter --}}
<div class="blog-filter-bar" id="blog-posts">
    <div class="wrap">
        <div class="blog-cats">
            <a href="{{ route('blog.index') }}#blog-posts" class="blog-cat {{ !request('category') || request('category') === 'all' ? 'on' : '' }}"><i class="ri-grid-line"></i> All Posts</a>
            <a href="{{ route('blog.index', ['category' => 'tutorials']) }}#blog-posts" class="blog-cat {{ request('category') === 'tutorials' ? 'on' : '' }}"><i class="ri-graduation-cap-line"></i> Tutorials</a>
            <a href="{{ route('blog.index', ['category' => 'updates']) }}#blog-posts" class="blog-cat {{ request('category') === 'updates' ? 'on' : '' }}"><i class="ri-notification-3-line"></i> Updates</a>
            <a href="{{ route('blog.index', ['category' => 'tips']) }}#blog-posts" class="blog-cat {{ request('category') === 'tips' ? 'on' : '' }}"><i class="ri-lightbulb-line"></i> Tips & Tricks</a>
            <a href="{{ route('blog.index', ['category' => 'news']) }}#blog-posts" class="blog-cat {{ request('category') === 'news' ? 'on' : '' }}"><i class="ri-newspaper-line"></i> Industry News</a>
        </div>
    </div>
</div>

{{-- Posts Grid --}}
<section class="blog-sec">
    <div class="wrap">

        {{-- Featured Post --}}
        @if($featuredBlog)
        <article class="blog-featured" data-category="{{ $featuredBlog->category }}" data-aos="fade-up">
            <div class="bf-img" style="background: {{ $featuredBlog->category_color }}20;">
                @if($featuredBlog->image)
                    <img src="{{ $featuredBlog->image }}" alt="{{ $featuredBlog->title }}" style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                @else
                    <div class="bf-img-inner">
                        <i class="{{ $featuredBlog->category_icon }}" style="color: {{ $featuredBlog->category_color }};"></i>
                    </div>
                @endif
                <span class="bf-cat" style="background: {{ $featuredBlog->category_color }}; color: #fff;">{{ $featuredBlog->category_label }}</span>
                <span class="bf-featured-tag"><i class="ri-star-fill"></i> Featured</span>
            </div>
            <div class="bf-body">
                <div class="bf-meta">
                    <span><i class="ri-calendar-line"></i> {{ $featuredBlog->published_at ? $featuredBlog->published_at->format('M d, Y') : $featuredBlog->created_at->format('M d, Y') }}</span>
                    <span><i class="ri-time-line"></i> {{ $featuredBlog->read_time }}</span>
                    <span><i class="ri-eye-line"></i> {{ number_format($featuredBlog->views) }} views</span>
                </div>
                <h2><a href="{{ route('blog.show', $featuredBlog->slug) }}" style="color: inherit; text-decoration: none;">{{ $featuredBlog->title }}</a></h2>
                <p>{{ $featuredBlog->excerpt ?? Str::limit(strip_tags($featuredBlog->content), 180) }}</p>
                <a href="{{ route('blog.show', $featuredBlog->slug) }}" class="btn btn-primary btn-sm">Read Full Article <i class="ri-arrow-right-line"></i></a>
            </div>
        </article>
        @endif

        {{-- Posts Grid --}}
        @if($blogs->count() > 0)
        <div class="blog-grid">
            @foreach($blogs as $post)
            <article class="blog-card" data-category="{{ $post->category }}" data-aos="fade-up">
                <div class="blog-card-img" style="background-color: {{ $post->category_color }}15; border-bottom: 3px solid {{ $post->category_color }}; position: relative;">
                    @if($post->image)
                        <img src="{{ $post->image }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                    @else
                        <i class="{{ $post->category_icon }}" style="color: {{ $post->category_color }};"></i>
                    @endif
                    <span class="bc-cat" style="background: {{ $post->category_color }}; color: #fff;">{{ $post->category_label }}</span>
                </div>
                <div class="blog-card-body">
                    <div class="bc-meta">
                        <span><i class="ri-calendar-line"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                        <span><i class="ri-time-line"></i> {{ $post->read_time }}</span>
                        <span><i class="ri-eye-line"></i> {{ number_format($post->views) }}</span>
                    </div>
                    <h3><a href="{{ route('blog.show', $post->slug) }}" style="color: inherit; text-decoration: none;">{{ $post->title }}</a></h3>
                    <p>{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-read-more">Read More <i class="ri-arrow-right-line"></i></a>
                </div>
            </article>
            @endforeach
        </div>

        <div style="margin-top: 48px;">
            {{ $blogs->withQueryString()->links() }}
        </div>
        @elseif(!$featuredBlog)
        <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 16px; border: 1px solid #e5e7eb;">
            <i class="ri-article-line" style="font-size: 3.5rem; color: #9ca3af; margin-bottom: 16px; display: inline-block;"></i>
            <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: var(--ink);">No Articles Published Yet</h3>
            <p style="color: var(--ink4); max-width: 400px; margin: 0 auto;">We are currently working on new exciting guides and tutorials. Check back soon!</p>
        </div>
        @endif

    </div>
</section>

{{-- Newsletter --}}
<section class="blog-nl-sec">
    <div class="wrap">
        <div class="blog-nl" data-aos="fade-up">
            <div class="blog-nl-left">
                <div class="blog-nl-ic"><i class="ri-mail-fill"></i></div>
                <div>
                    <h3>Stay <em>Updated</em></h3>
                    <p>Get the latest IPTV news, tutorials, and exclusive deals in your inbox.</p>
                </div>
            </div>
            <form class="blog-nl-form">
                <div class="blog-nl-wrap">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit" class="btn btn-primary"><i class="ri-send-plane-fill"></i> Subscribe</button>
                </div>
                <small><i class="ri-shield-check-line"></i> We respect your privacy. Unsubscribe anytime.</small>
            </form>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Filter Bar ── */
.blog-filter-bar {
    background: #fff;
    border-bottom: var(--bdr);
    padding: 14px 0;
}
.blog-cats { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
.blog-cat {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; font-size: 0.85rem; font-weight: 700;
    color: var(--ink4); border-radius: var(--rr);
    border: 1.5px solid transparent;
    background: var(--bg2); cursor: pointer;
    transition: var(--t); font-family: var(--font);
    text-decoration: none;
}
.blog-cat:hover { color: var(--primary); background: var(--primary-soft); border-color: var(--primary-glow); }
.blog-cat.on { background: var(--primary); color: #fff; border-color: var(--primary); }

/* ── Blog Section ── */
.blog-sec { padding: 60px 0; }

/* ── Featured Post ── */
.blog-featured {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 0;
    border-radius: 20px;
    overflow: hidden;
    border: 1.5px solid #e5e7eb;
    box-shadow: var(--s2);
    margin-bottom: 40px;
    background: #fff;
    transition: var(--ts);
}
.blog-featured:hover { transform: translateY(-5px); box-shadow: var(--s4); }

.bf-img {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    min-height: 340px;
    display: flex; align-items: center; justify-content: center;
    position: relative;
    overflow: hidden;
}
.bf-img::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Ccircle fill='%23ffffff08' cx='20' cy='20' r='3'/%3E%3C/g%3E%3C/svg%3E");
}
.bf-img-inner i { font-size: 5rem; color: rgba(255,255,255,0.25); position: relative; z-index: 2; }

.bf-cat {
    position: absolute; top: 16px; left: 16px;
    background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);
    color: #fff; padding: 5px 14px;
    border-radius: var(--rr); font-size: 0.72rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 1px;
}
.bf-featured-tag {
    position: absolute; bottom: 16px; left: 16px;
    background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
    color: #fff; padding: 5px 14px;
    border-radius: var(--rr); font-size: 0.72rem; font-weight: 800;
    display: flex; align-items: center; gap: 5px;
}
.bf-featured-tag i { color: #fbbf24; }

.bf-body {
    padding: 44px 40px;
    display: flex; flex-direction: column; justify-content: center;
}
.bf-meta { display: flex; gap: 16px; margin-bottom: 14px; flex-wrap: wrap; }
.bf-meta span { display: flex; align-items: center; gap: 5px; font-size: 0.78rem; color: var(--ink5); }
.bf-body h2 { font-size: 1.6rem; margin-bottom: 14px; color: var(--ink); line-height: 1.3; }
.bf-body p { font-size: 0.93rem; color: var(--ink4); line-height: 1.7; margin-bottom: 24px; }

/* ── Blog Cards ── */
.blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}
.blog-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    transition: var(--ts);
    box-shadow: var(--s1);
}
.blog-card:hover { transform: translateY(-6px); box-shadow: var(--s4); }

.blog-card-img {
    height: 160px;
    display: flex; align-items: center; justify-content: center;
    position: relative;
}
.blog-card-img i { font-size: 3.2rem; }
.bc-cat {
    position: absolute; top: 12px; left: 12px;
    background: rgba(255,255,255,0.9); backdrop-filter: blur(6px);
    color: var(--ink2); padding: 4px 12px;
    border-radius: var(--rr); font-size: 0.68rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 1px;
}

.blog-card-body { padding: 22px; }
.bc-meta { display: flex; gap: 12px; margin-bottom: 12px; flex-wrap: wrap; }
.bc-meta span { display: flex; align-items: center; gap: 4px; font-size: 0.75rem; color: var(--ink5); }
.blog-card-body h3 {
    font-size: 1rem; margin-bottom: 10px;
    color: var(--ink); line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.blog-card:hover h3 { color: var(--primary); }
.blog-card-body p {
    font-size: 0.86rem; color: var(--ink4); line-height: 1.65;
    margin-bottom: 16px;
    display: -webkit-box; -webkit-line-clamp: 3;
    -webkit-box-orient: vertical; overflow: hidden;
}
.blog-read-more {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.85rem; font-weight: 800; color: var(--primary);
    transition: var(--t);
    text-decoration: none;
}
.blog-read-more:hover { gap: 10px; }

/* ── Newsletter ── */
.blog-nl-sec { background: var(--dark); padding: 60px 0; }
.blog-nl {
    display: flex; align-items: center; gap: 48px;
    flex-wrap: wrap;
}
.blog-nl-left { display: flex; align-items: center; gap: 20px; flex: 1; min-width: 280px; }
.blog-nl-ic {
    width: 56px; height: 56px; border-radius: 14px;
    background: var(--primary); display: grid; place-items: center;
    font-size: 1.6rem; color: #fff; flex-shrink: 0;
}
.blog-nl-left h3 { font-size: 1.4rem; color: #fff; margin-bottom: 4px; }
.blog-nl-left h3 em { font-style: normal; color: var(--primary); }
.blog-nl-left p { color: rgba(255,255,255,0.55); font-size: 0.9rem; }

.blog-nl-form { flex: 1; min-width: 300px; }
.blog-nl-wrap { display: flex; gap: 8px; margin-bottom: 8px; }
.blog-nl-wrap input {
    flex: 1; padding: 13px 18px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: var(--r2);
    color: #fff; font-family: var(--font); font-size: 0.92rem;
    outline: none; transition: var(--t);
}
.blog-nl-wrap input::placeholder { color: rgba(255,255,255,0.35); }
.blog-nl-wrap input:focus { border-color: var(--primary); background: rgba(255,77,28,0.06); }
.blog-nl-form small {
    font-size: 0.75rem; color: rgba(255,255,255,0.3);
    display: flex; align-items: center; gap: 5px;
}
.blog-nl-form small i { color: var(--success); }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .blog-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 768px) {
    .blog-featured { grid-template-columns: 1fr; }
    .bf-img { min-height: 220px; }
    .bf-body { padding: 28px 24px; }
    .blog-grid { grid-template-columns: 1fr; }
    .blog-nl { flex-direction: column; gap: 28px; }
    .blog-nl-wrap { flex-direction: column; }
    .blog-cats { justify-content: flex-start; overflow-x: auto; flex-wrap: nowrap; padding-bottom: 4px; }
    .blog-cat { flex-shrink: 0; }
}
</style>
@endpush
