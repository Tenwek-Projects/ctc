<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(Request $request): Response
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');

        $sitemaps = [
            $base . '/sitemaps/pages.xml',
            $base . '/sitemaps/news.xml',
            $base . '/sitemaps/services.xml',
            $base . '/sitemaps/specialists.xml',
        ];

        $xml = view('seo.sitemap-index', compact('sitemaps'));
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function pages(Request $request): Response
    {
        $urls = [
            route('home'),
            route('about'),
            route('history'),
            route('services'),
            route('specialists'),
            route('patient-information'),
            route('international-patients'),
            route('training-research'),
            route('training'),
            route('training.fellowship-rotations'),
            route('training.perfusion'),
            route('research'),
            route('research.publications'),
            route('impact'),
            route('support'),
            route('news'),
            route('gallery'),
            route('contact'),
            route('book-appointment'),
            route('privacy-policy'),
            route('terms-of-service'),
            route('feedback'),
        ];

        $items = collect($urls)->unique()->map(fn ($loc) => [
            'loc' => $loc,
            'changefreq' => 'weekly',
            'priority' => $loc === route('home') ? '1.0' : '0.7',
            'lastmod' => null,
        ])->all();

        $xml = view('seo.sitemap-urlset', ['items' => $items]);
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function news(Request $request): Response
    {
        $items = NewsArticle::query()
            ->published()
            ->latest()
            ->get(['slug', 'updated_at', 'published_at', 'created_at'])
            ->map(fn ($a) => [
                'loc' => route('news.show', $a->slug),
                'changefreq' => 'monthly',
                'priority' => '0.8',
                'lastmod' => optional($a->updated_at ?? $a->published_at ?? $a->created_at)->toAtomString(),
            ])->all();

        $xml = view('seo.sitemap-urlset', ['items' => $items]);
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function services(Request $request): Response
    {
        $items = Service::query()
            ->visible()
            ->ordered()
            ->get(['slug', 'updated_at', 'created_at'])
            ->map(fn ($s) => [
                'loc' => route('services.show', $s->slug),
                'changefreq' => 'monthly',
                'priority' => '0.7',
                'lastmod' => optional($s->updated_at ?? $s->created_at)->toAtomString(),
            ])->all();

        // also include the 3 category pages
        foreach (['cardiac-surgery', 'thoracic-surgery', 'diagnostics'] as $seg) {
            $items[] = [
                'loc' => route('services.category', ['serviceCategory' => $seg]),
                'changefreq' => 'monthly',
                'priority' => '0.7',
                'lastmod' => null,
            ];
        }

        $xml = view('seo.sitemap-urlset', ['items' => $items]);
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function specialists(Request $request): Response
    {
        $items = TeamMember::query()
            ->visible()
            ->ordered()
            ->get(['slug', 'updated_at', 'created_at'])
            ->map(fn ($m) => [
                'loc' => route('specialists.show', $m->slug),
                'changefreq' => 'monthly',
                'priority' => '0.6',
                'lastmod' => optional($m->updated_at ?? $m->created_at)->toAtomString(),
            ])->all();

        $xml = view('seo.sitemap-urlset', ['items' => $items]);
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(Request $request): Response
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');
        $content = "User-agent: *\nAllow: /\n\nSitemap: {$base}/sitemap.xml\n";
        return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}

