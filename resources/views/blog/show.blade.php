@extends('layouts.app')
@section('title', $blog->title . ' — Live IPTV Now Blog')
@section('meta_description', $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150))

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/hero_blog.png',
    'breadcrumb'     => 'Blog Article',
    'badge'          => $blog->category_label,
    'badgeIcon'      => $blog->category_icon,
    'title'          => $blog->title,
    'accent'         => '',
    'subtitle'       => 'Published on ' . ($blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y')) . ' · ' . $blog->read_time . ' · ' . number_format($blog->views) . ' views',
    'desc'           => $blog->excerpt ?? '',
    'ctaPrimary'     => 'Back to Blog',
    'ctaPrimaryUrl'  => route('blog.index'),
    'ctaPrimaryIcon' => 'ri-arrow-left-line',
    'ctaGhost'       => 'Get IPTV Plan',
    'ctaGhostUrl'    => route('packages.index'),
    'ctaGhostIcon'   => 'ri-play-circle-line',
])

<section class="blog-show-sec" style="padding: 60px 0; background: #f8fafc;">
    <div class="wrap" style="max-width: 900px;">
        <article class="blog-article-card" style="background: #fff; border-radius: 20px; border: 1.5px solid #e2e8f0; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 50px;">
            @if($blog->image)
                <div style="margin: -40px -40px 30px -40px; border-radius: 20px 20px 0 0; overflow: hidden; max-height: 450px;">
                    <img src="{{ $blog->image }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endif

            <div class="article-content" style="font-size: 1.05rem; line-height: 1.8; color: #334155;">
                {!! $blog->content !!}
            </div>

            <hr style="margin: 40px 0; border-color: #e2e8f0;">

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-weight: 700; color: #64748b; font-size: 0.9rem;">Share Article:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #1877f2; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;"><i class="ri-facebook-fill"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #1da1f2; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;"><i class="ri-twitter-x-fill"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . request()->fullUrl()) }}" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;"><i class="ri-whatsapp-fill"></i></a>
                </div>
                <a href="{{ route('blog.index') }}" class="btn btn-outline" style="font-size: 0.85rem;"><i class="ri-arrow-left-line"></i> All Articles</a>
            </div>
        </article>

        @if($relatedBlogs->count() > 0)
        <div style="margin-top: 60px;">
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 24px; color: #1e293b;"><i class="ri-article-line me-2" style="color: var(--primary);"></i> Related Articles</h3>
            <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                @foreach($relatedBlogs as $post)
                <article class="blog-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <div class="blog-card-img" style="height: 140px; background-color: {{ $post->category_color }}15; border-bottom: 3px solid {{ $post->category_color }}; position: relative; display: flex; align-items: center; justify-content: center;">
                        @if($post->image)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                        @else
                            <i class="{{ $post->category_icon }}" style="font-size: 2.5rem; color: {{ $post->category_color }};"></i>
                        @endif
                        <span style="position: absolute; top: 10px; left: 10px; background: {{ $post->category_color }}; color: #fff; padding: 3px 10px; border-radius: 99px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">{{ $post->category_label }}</span>
                    </div>
                    <div style="padding: 18px;">
                        <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 8px;"><a href="{{ route('blog.show', $post->slug) }}" style="color: #1e293b; text-decoration: none;">{{ $post->title }}</a></h4>
                        <a href="{{ route('blog.show', $post->slug) }}" style="font-size: 0.8rem; font-weight: 700; color: var(--primary); text-decoration: none;">Read Article <i class="ri-arrow-right-line"></i></a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
.article-content h1, .article-content h2, .article-content h3, .article-content h4 {
    color: #1e293b; font-weight: 800; margin-top: 1.8em; margin-bottom: 0.6em; line-height: 1.3;
}
.article-content p { margin-bottom: 1.4em; }
.article-content ul, .article-content ol { margin-bottom: 1.4em; padding-left: 1.5em; }
.article-content li { margin-bottom: 0.5em; }
.article-content a { color: var(--primary); text-decoration: underline; }
.article-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 1.5em 0; }
.article-content blockquote { border-left: 4px solid var(--primary); padding: 1em 1.5em; background: #f1f5f9; border-radius: 0 12px 12px 0; margin: 1.5em 0; font-style: italic; }
</style>
@endpush
