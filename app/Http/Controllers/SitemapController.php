<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Models\DepartmentPage;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    private const CACHE_TTL_SECONDS = 3600;

    public function index(Request $request): Response
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');

        $sitemaps = [
            $base.'/sitemaps/pages.xml',
            $base.'/sitemaps/news.xml',
            $base.'/sitemaps/services.xml',
            $base.'/sitemaps/specialists.xml',
        ];

        $xml = view('seo.sitemap-index', compact('sitemaps'));

        return $this->xmlResponse($xml);
    }

    public function pages(Request $request): Response
    {
        $cacheKey = 'sitemap.pages.'.$request->getSchemeAndHttpHost();

        $xml = Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () {
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
                route('training.medical-education'),
                route('research'),
                route('research.publications'),
                route('impact'),
                route('support'),
                route('news'),
                route('events'),
                route('gallery'),
                route('contact'),
                route('book-appointment'),
                route('college.apply.landing'),
                route('privacy-policy'),
                route('terms-of-service'),
                route('feedback'),
            ];

            foreach (DepartmentPage::query()->visible()->ordered()->get(['url_segment']) as $department) {
                $urls[] = route('departments.show', $department);
            }

            $items = collect($urls)->unique()->map(fn ($loc) => [
                'loc' => $loc,
                'changefreq' => 'weekly',
                'priority' => $loc === route('home') ? '1.0' : '0.7',
                'lastmod' => null,
            ])->all();

            return view('seo.sitemap-urlset', ['items' => $items])->render();
        });

        return $this->xmlResponse($xml);
    }

    public function news(Request $request): Response
    {
        $cacheKey = 'sitemap.news.'.$request->getSchemeAndHttpHost();

        $xml = Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () {
            $items = NewsArticle::query()
                ->published()
                ->latest()
                ->get(['slug', 'type', 'updated_at', 'published_at', 'created_at'])
                ->map(fn ($a) => [
                    'loc' => $a->type === NewsArticle::TYPE_EVENT ? route('events.show', $a->slug) : route('news.show', $a->slug),
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                    'lastmod' => optional($a->updated_at ?? $a->published_at ?? $a->created_at)->toAtomString(),
                ])->all();

            return view('seo.sitemap-urlset', ['items' => $items])->render();
        });

        return $this->xmlResponse($xml);
    }

    public function services(Request $request): Response
    {
        $cacheKey = 'sitemap.services.'.$request->getSchemeAndHttpHost();

        $xml = Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () {
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

            foreach (['cardiac-surgery', 'thoracic-surgery', 'diagnostics'] as $seg) {
                $items[] = [
                    'loc' => route('services.category', ['serviceCategory' => $seg]),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                    'lastmod' => null,
                ];
            }

            return view('seo.sitemap-urlset', ['items' => $items])->render();
        });

        return $this->xmlResponse($xml);
    }

    public function specialists(Request $request): Response
    {
        $cacheKey = 'sitemap.specialists.'.$request->getSchemeAndHttpHost();

        $xml = Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () {
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

            return view('seo.sitemap-urlset', ['items' => $items])->render();
        });

        return $this->xmlResponse($xml);
    }

    public function robots(Request $request): Response
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin-dashboard',
            'Disallow: /admin-dashboard/',
            '',
            "Sitemap: {$base}/sitemap.xml",
            '',
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    private function xmlResponse(string $xml): Response
    {
        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
