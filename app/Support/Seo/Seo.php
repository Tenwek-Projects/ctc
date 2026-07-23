<?php

namespace App\Support\Seo;

use App\Models\ContactSetting;
use App\Models\SiteSetting;
use App\Support\PublicAssetUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Seo
{
    /**
     * Build page SEO meta + JSON-LD in one place.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function build(Request $request, array $overrides = []): array
    {
        $siteName = (string) config('ctc.name');
        $hospital = (string) config('ctc.hospital');

        $routeName = $request->route()?->getName();
        $routeDefaults = self::defaultsForRoute($routeName, $overrides);

        $pageSegment = self::resolvePageSegment(
            $overrides['title'] ?? $overrides['pageTitle'] ?? null,
            $routeDefaults['title'] ?? null,
            $routeName
        );

        $title = self::brandTitle($pageSegment);
        $description = self::normalizeDescription(
            $overrides['description'] ?? $routeDefaults['description'] ?? config('ctc.tagline')
        );

        $canonical = self::absoluteUrl($request, $overrides['canonical'] ?? $request->url());
        $defaultImage = \App\Support\SiteImage::urlFor('og')
            ?? PublicAssetUrl::toUrl('ctc.jpg')
            ?? self::absoluteUrl($request, '/ctc.jpg');
        $image = self::absoluteUrl($request, $overrides['image'] ?? $defaultImage);

        $keywords = $overrides['keywords'] ?? $routeDefaults['keywords'] ?? null;
        $robots = $overrides['robots'] ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';

        $locale = str_replace('_', '-', app()->getLocale());
        $type = $overrides['og_type'] ?? $routeDefaults['og_type'] ?? 'website';

        $contact = ContactSetting::current();
        $social = array_filter([
            'https://www.instagram.com/agctenwekcardiothoraciccentre',
            'https://www.linkedin.com/in/agctenwek-cardiothoracic-centre-6257b1368',
            'https://www.facebook.com/share/1DVKQQxtz5/',
            'https://www.tiktok.com/@agc_tenwek',
            SiteSetting::getValue('social.x'),
            SiteSetting::getValue('social.youtube'),
        ]);

        $schemas = [];
        $schemas[] = self::schemaWebSite($request, $siteName);
        $logoUrl = \App\Support\SiteImage::urlFor('logo')
            ?? PublicAssetUrl::toUrl('logo-ctc.png')
            ?? self::absoluteUrl($request, '/logo-ctc.png');
        $schemas[] = self::schemaOrganization($request, $siteName, $hospital, $contact, $social, $logoUrl);

        if (! empty($overrides['breadcrumbs']) && is_array($overrides['breadcrumbs'])) {
            $schemas[] = self::schemaBreadcrumbs($request, $overrides['breadcrumbs']);
        }

        if (! empty($overrides['schema']) && is_array($overrides['schema'])) {
            foreach ($overrides['schema'] as $block) {
                if (is_array($block)) {
                    $schemas[] = $block;
                }
            }
        }

        $schemas[] = self::schemaWebPage($request, $title, $description, $canonical, $image);

        return [
            'title' => $title,
            'page_segment' => $pageSegment,
            'description' => $description,
            'keywords' => $keywords,
            'canonical' => $canonical,
            'robots' => $robots,
            'og' => [
                'type' => $type,
                'url' => $canonical,
                'title' => $overrides['og_title'] ?? $title,
                'description' => $overrides['og_description'] ?? $description,
                'image' => $image,
                'site_name' => $siteName,
                'locale' => $locale,
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $overrides['twitter_title'] ?? $title,
                'description' => $overrides['twitter_description'] ?? $description,
                'image' => $image,
            ],
            'meta' => [
                'author' => $overrides['author'] ?? $siteName,
                'language' => $locale,
                'geo_region' => 'KE',
                'geo_placename' => 'Bomet, Kenya',
            ],
            'schema' => array_values(array_filter($schemas)),
        ];
    }

    /**
     * Public title builder: "Page | Cardiothoracic Centre | Tenwek Hospital"
     */
    public static function brandTitle(?string $pageSegment): string
    {
        $centre = (string) config('ctc.name');
        $hospital = (string) config('ctc.hospital');
        $suffix = "{$centre} | {$hospital}";

        $page = self::stripBrandParts((string) $pageSegment, $centre, $hospital);

        if ($page === '') {
            return $suffix;
        }

        // Avoid "Cardiothoracic Centre | Cardiothoracic Centre | Tenwek Hospital"
        if (strcasecmp($page, $centre) === 0) {
            return $suffix;
        }

        return "{$page} | {$suffix}";
    }

    /**
     * Merge Blade @section('title') with SEO defaults into a final document title.
     */
    public static function documentTitle(?string $sectionTitle, ?string $seoTitle = null, ?string $routeName = null): string
    {
        $segment = self::resolvePageSegment($sectionTitle, $seoTitle, $routeName);

        return self::brandTitle($segment);
    }

    private static function resolvePageSegment(mixed $primary, mixed $fallback, ?string $routeName): string
    {
        $primary = is_string($primary) ? trim($primary) : '';
        $fallback = is_string($fallback) ? trim($fallback) : '';

        $weak = ['home', 'index', ''];

        if ($primary !== '' && ! in_array(strtolower($primary), $weak, true)) {
            return self::stripBrandParts($primary);
        }

        if ($fallback !== '' && ! in_array(strtolower($fallback), $weak, true)) {
            return self::stripBrandParts($fallback);
        }

        if ($routeName === 'home' || $routeName === null) {
            return 'Healing Hearts Across East Africa';
        }

        return '';
    }

    private static function stripBrandParts(string $title, ?string $centre = null, ?string $hospital = null): string
    {
        $centre ??= (string) config('ctc.name');
        $hospital ??= (string) config('ctc.hospital');

        $title = trim($title);
        if ($title === '') {
            return '';
        }

        // Remove repeated brand suffixes.
        $patterns = [
            '/\s*\|\s*'.preg_quote($centre, '/').'\s*\|\s*'.preg_quote($hospital, '/').'\s*$/iu',
            '/\s*\|\s*'.preg_quote($hospital, '/').'\s*\|\s*'.preg_quote($centre, '/').'\s*$/iu',
            '/\s*\|\s*'.preg_quote($centre, '/').'\s*$/iu',
            '/\s*\|\s*'.preg_quote($hospital, '/').'\s*$/iu',
            '/\s*\|\s*Tenwek\s+Cardiothoracic\s+Centre\s*$/iu',
            '/\s*\|\s*AGC\s+Tenwek\s+Cardiothoracic\s+Centre\s*$/iu',
        ];

        foreach ($patterns as $pattern) {
            $title = preg_replace($pattern, '', $title) ?? $title;
        }

        return trim($title, " \t\n\r\0\x0B|");
    }

    /** @return array<string, mixed> */
    private static function defaultsForRoute(?string $routeName, array $overrides): array
    {
        $siteName = (string) config('ctc.name');

        $map = [
            'home' => [
                'title' => 'Healing Hearts Across East Africa',
                'description' => "{$siteName} at Tenwek Hospital delivers specialist cardiac and thoracic surgery, diagnostics, training and research for patients across Kenya and East Africa.",
                'keywords' => 'cardiothoracic centre, cardiac surgery kenya, thoracic surgery kenya, heart surgery east africa, tenwek hospital ctc',
            ],
            'about' => [
                'title' => 'About the Centre',
                'description' => "Discover {$siteName}: who we are, our mission and values, and our commitment to safe, compassionate heart and chest care in East Africa.",
                'keywords' => 'about cardiothoracic centre, tenwek ctc mission, heart surgery kenya',
            ],
            'history' => [
                'title' => 'Our History',
                'description' => "Milestones that shaped {$siteName} and expanded access to advanced cardiac care across Africa.",
                'keywords' => 'cardiothoracic centre history, tenwek ctc milestones',
            ],
            'services' => [
                'title' => 'Our Services',
                'description' => "Explore {$siteName} services: adult and paediatric cardiac surgery, thoracic surgery, cath lab, diagnostics and critical care.",
                'keywords' => 'cardiac surgery, thoracic surgery, cardiothoracic services kenya, cath lab, diagnostics',
            ],
            'services.category' => [
                'title' => 'Clinical Services',
                'description' => "Specialist cardiothoracic service areas at {$siteName}, Tenwek Hospital.",
            ],
            'services.show' => [
                'title' => 'Clinical Service',
                'description' => "Specialist care at {$siteName}, Tenwek Hospital.",
            ],
            'specialists' => [
                'title' => 'Our Specialists',
                'description' => "Meet the surgeons and multidisciplinary team at {$siteName} providing specialist cardiac and thoracic care.",
                'keywords' => 'cardiothoracic surgeons kenya, cardiac specialists, thoracic surgeon kenya',
            ],
            'specialists.show' => [
                'title' => 'Specialist Profile',
            ],
            'news' => [
                'title' => 'News & Media',
                'description' => "Updates, events and announcements from {$siteName}: training, milestones and stories from the CTC.",
                'keywords' => 'cardiothoracic centre news, ctc events kenya',
            ],
            'news.show' => [
                'og_type' => 'article',
            ],
            'gallery' => [
                'title' => 'Gallery',
                'description' => "Moments from {$siteName}: people, care, facility and community.",
                'keywords' => 'cardiothoracic centre gallery, tenwek ctc photos',
            ],
            'contact' => [
                'title' => 'Contact Us',
                'description' => "Contact {$siteName} for appointments, referrals and enquiries. Located at Tenwek Hospital, Bomet, Kenya.",
                'keywords' => 'contact cardiothoracic centre, referrals kenya, book appointment',
            ],
            'book-appointment' => [
                'title' => 'Book an Appointment',
                'description' => "Request an appointment or consultation at {$siteName}. Submit details online for referrals and scheduling.",
                'keywords' => 'book appointment cardiothoracic centre, cardiac referral kenya',
            ],
            'training' => [
                'title' => 'Education & Training',
                'description' => "Shape the future of cardiothoracic care through fellowship and perfusion training at {$siteName}.",
                'keywords' => 'cardiothoracic training africa, fellowship kenya, perfusion school',
            ],
            'training-research' => [
                'title' => 'Training & Research',
                'description' => "Training and research hub at {$siteName}: fellowship pathways, perfusion school and clinical research.",
            ],
            'research' => [
                'title' => 'Research',
                'description' => "Research at {$siteName}: publications and outcomes learning that strengthens care in resource-limited settings.",
                'keywords' => 'cardiothoracic research, outcomes research, ctc publications',
            ],
            'research.publications' => [
                'title' => 'Research Publications',
                'description' => "Peer-reviewed publications and research outputs from {$siteName}.",
                'keywords' => 'cardiothoracic research papers, ctc publications',
            ],
            'training.fellowship-rotations' => [
                'title' => 'Cardiothoracic Surgery Fellowship',
                'description' => "PAACS fellowship in collaboration with COSECSA at {$siteName} — adult and paediatric cardiothoracic surgery training.",
                'keywords' => 'cardiothoracic fellowship kenya, PAACS, COSECSA',
            ],
            'training.perfusion' => [
                'title' => 'Cardiovascular Perfusion Training',
                'description' => "Cardiovascular Perfusion Training Program at {$siteName}: classroom, simulation and clinical experience.",
                'keywords' => 'perfusion school kenya, cardiovascular perfusion training',
            ],
            'patient-information' => [
                'title' => 'Patient Information',
                'description' => "Practical guidance for patients and families preparing for care at {$siteName}.",
            ],
            'international-patients' => [
                'title' => 'International Patients',
                'description' => "Guidance for international patients seeking cardiothoracic care at {$siteName}: referrals, records, travel and coordination.",
                'keywords' => 'international patients cardiac surgery kenya, medical travel tenwek',
            ],
            'impact' => [
                'title' => 'Our Impact',
                'description' => "Impact stories and outcomes from {$siteName}: patient stories, training, and expanded access to life-saving care across Africa.",
                'keywords' => 'cardiothoracic centre impact, patient stories africa',
            ],
            'support' => [
                'title' => 'Support the Centre',
                'description' => "Support {$siteName} through giving and partnership to expand access to surgery and training.",
                'keywords' => 'donate cardiothoracic centre, support heart surgery kenya',
            ],
            'privacy-policy' => [
                'title' => 'Privacy Policy',
                'description' => "Privacy policy for the {$siteName} website.",
            ],
            'terms-of-service' => [
                'title' => 'Terms of Service',
                'description' => "Terms of service for the {$siteName} website.",
            ],
            'feedback' => [
                'title' => 'Feedback & Complaints',
                'description' => "Submit feedback or complaints to {$siteName}. We take patient experience seriously.",
            ],
            'college.apply.landing' => [
                'title' => 'Perfusion School Application',
                'description' => "Apply online for the Cardiovascular Perfusion Training Program at {$siteName}.",
            ],
        ];

        $defaults = $routeName ? ($map[$routeName] ?? []) : [];

        if (! empty($overrides['pageTitle']) && empty($overrides['title'])) {
            $defaults['title'] = $overrides['pageTitle'];
        }

        return $defaults;
    }

    private static function normalizeDescription(?string $description): string
    {
        $description = trim((string) $description);
        $description = preg_replace('/\s+/', ' ', $description) ?: '';

        return Str::limit($description, 160, '…');
    }

    private static function absoluteUrl(Request $request, ?string $url): ?string
    {
        if (! $url) {
            return null;
        }
        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        return rtrim($request->getSchemeAndHttpHost(), '/').'/'.ltrim($url, '/');
    }

    /** @return array<string, mixed> */
    private static function schemaWebSite(Request $request, string $siteName): array
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $base.'/#website',
            'name' => $siteName,
            'alternateName' => 'CTC',
            'url' => $base.'/',
            'inLanguage' => str_replace('_', '-', app()->getLocale()),
            'publisher' => ['@id' => $base.'/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $base.'/news?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /** @return array<string, mixed> */
    private static function schemaWebPage(Request $request, string $title, string $description, string $canonical, string $image): array
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'inLanguage' => str_replace('_', '-', app()->getLocale()),
            'isPartOf' => ['@id' => $base.'/#website'],
            'about' => ['@id' => $base.'/#organization'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url' => $image,
            ],
        ];
    }

    /** @param  array<int, string>  $sameAs */
    private static function schemaOrganization(Request $request, string $siteName, string $hospital, ContactSetting $contact, array $sameAs, string $logoUrl): array
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');
        $address = trim((string) ($contact->address ?? ''));

        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalOrganization',
            '@id' => $base.'/#organization',
            'name' => $siteName,
            'alternateName' => [
                'CTC',
                'AGC Tenwek Cardiothoracic Centre',
                'Tenwek Cardiothoracic Centre',
            ],
            'url' => $base.'/',
            'logo' => $logoUrl,
            'image' => $logoUrl,
            'sameAs' => array_values($sameAs),
            'parentOrganization' => [
                '@type' => 'Hospital',
                'name' => $hospital,
                'url' => 'https://tenwekhosp.org/',
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressLocality' => 'Bomet',
                'addressRegion' => 'Bomet County',
                'addressCountry' => 'KE',
            ],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'Kenya'],
                ['@type' => 'Place', 'name' => 'East Africa'],
            ],
            'contactPoint' => array_values(array_filter([
                filled($contact->phone) ? [
                    '@type' => 'ContactPoint',
                    'contactType' => 'customer support',
                    'telephone' => $contact->phone,
                    'email' => $contact->email,
                    'areaServed' => 'KE',
                    'availableLanguage' => ['en'],
                ] : null,
                filled($contact->emergency_phone) ? [
                    '@type' => 'ContactPoint',
                    'contactType' => 'emergency',
                    'telephone' => $contact->emergency_phone,
                    'areaServed' => 'KE',
                    'availableLanguage' => ['en'],
                ] : null,
            ])),
        ];
    }

    /**
     * @param  array<int, array{label: string, url: string}>  $items
     * @return array<string, mixed>
     */
    private static function schemaBreadcrumbs(Request $request, array $items): array
    {
        $base = rtrim($request->getSchemeAndHttpHost(), '/');
        $list = [];
        $pos = 1;
        foreach ($items as $item) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $item['label'],
                'item' => self::absoluteUrl($request, $item['url']),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            '@id' => $base.'/#breadcrumbs',
            'itemListElement' => $list,
        ];
    }
}
