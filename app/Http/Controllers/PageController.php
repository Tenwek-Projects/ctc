<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Booking;
use App\Models\ContactEnquiry;
use App\Models\ContactSetting;
use App\Models\CoreValue;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\HistoryGalleryItem;
use App\Models\HistoryMilestone;
use App\Models\HomeStat;
use App\Models\ImpactStory;
use App\Models\ImpactTestimonial;
use App\Models\NewsArticle;
use App\Models\ResourceDownload;
use App\Models\Service;
use App\Models\ServiceCategoryPage;
use App\Models\DepartmentPage;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Support\LegalPageContent;
use App\Support\PublicAssetUrl;
use App\Support\Seo\Seo;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $stats = HomeStat::query()->visible()->ordered()->get(['value', 'label']);
        if ($stats->isEmpty()) {
            $stats = collect([
                ['value' => '5,000+', 'label' => 'Surgeries Performed'],
                ['value' => '15+', 'label' => 'Countries Served'],
                ['value' => '25+', 'label' => 'Years of Experience'],
                ['value' => '50+', 'label' => 'Surgeons Trained'],
            ]);
        }

        $serviceColumns = ['id', 'name', 'slug', 'category', 'description', 'sort_order', 'is_visible', 'show_on_homepage'];
        $teamColumns = ['id', 'name', 'slug', 'credentials', 'title', 'team_group', 'specialization', 'bio', 'photo', 'sort_order', 'is_visible', 'show_on_homepage'];
        $newsColumns = ['id', 'title', 'slug', 'type', 'excerpt', 'featured_image', 'published_at', 'is_published', 'created_at'];

        $services = Service::visible()->onHomepage()->ordered()->take(8)->get($serviceColumns);
        if ($services->isEmpty()) {
            $services = Service::visible()->ordered()->take(8)->get($serviceColumns);
        }
        $team = TeamMember::visible()->onHomepage()->ordered()->take(8)->get($teamColumns);
        if ($team->isEmpty()) {
            $team = TeamMember::visible()->ordered()->take(4)->get($teamColumns);
        }
        $news = NewsArticle::published()->latest()->take(3)->get($newsColumns);

        $configuredHeroMode = SiteSetting::getValue('hero.mode', 'image');
        $hasCustomHeroVideo = filled(SiteSetting::getValue('hero.video_path'))
            || filled(SiteSetting::getValue('hero.video_url'));
        $heroMode = match (true) {
            $configuredHeroMode === 'carousel' => 'carousel',
            $configuredHeroMode === 'video' && $hasCustomHeroVideo => 'video',
            default => 'image',
        };
        $heroTitle = SiteSetting::getValue('hero.title', 'AGC Tenwek Cardiothoracic Centre');
        $heroSubtitle = SiteSetting::getValue('hero.subtitle', 'Tenwek Hospital');
        $heroDescription = SiteSetting::getValue('hero.description', 'A beacon of hope and healing for patients with heart disease across Sub‑Saharan Africa. We provide life‑saving open‑heart and thoracic care, and train African healthcare professionals to expand access to treatment.');
        $heroImageUrl = \App\Support\SiteImage::urlFor('hero_image')
            ?: asset(config('ctc.hero_image', 'hero.jpg'));
        $heroVideoPath = SiteSetting::getValue('hero.video_path');
        $heroVideoUrl = $heroVideoPath
            ? PublicAssetUrl::toUrl($heroVideoPath)
            : SiteSetting::getValue('hero.video_url', config('ctc.hero_video'));
        $heroSlides = HeroSlide::query()->visible()->ordered()->get();
        $servicesImageUrl = \App\Support\SiteImage::urlFor('home_services')
            ?: asset('service-home.webp');

        $supportCtaImageUrl = \App\Support\SiteImage::urlFor('home_support_cta')
            ?: asset('hero.jpg');

        return view('pages.home', compact(
            'stats',
            'services',
            'team',
            'news',
            'heroMode',
            'heroTitle',
            'heroSubtitle',
            'heroDescription',
            'heroImageUrl',
            'heroVideoUrl',
            'heroSlides',
            'servicesImageUrl',
            'supportCtaImageUrl'
        ));
    }

    public function about()
    {
        $sections = AboutSection::query()->visible()->ordered()->get();
        $coreValues = CoreValue::query()->visible()->ordered()->get();

        $whoWeAre = [
            'kicker' => SiteSetting::getValue('about.who_we_are.kicker', 'Who we are'),
            'heading' => SiteSetting::getValue('about.who_we_are.heading', 'Specialist heart & chest care, grounded in compassion'),
            'body' => SiteSetting::getValue('about.who_we_are.body', "The Cardiothoracic Centre (CTC) at Tenwek Hospital provides comprehensive care for adult and pediatric patients with cardiac and thoracic conditions,\nfrom diagnosis through surgery and follow‑up."),
            'bullets' => [
                SiteSetting::getValue('about.who_we_are.bullet_1', 'Integrated teams across surgery, anesthesia, ICU, nursing, and diagnostics.'),
                SiteSetting::getValue('about.who_we_are.bullet_2', 'Focused on safe, evidence‑based care with long‑term follow‑up.'),
                SiteSetting::getValue('about.who_we_are.bullet_3', 'Training and mentorship that strengthens local capacity across Africa.'),
            ],
            'images' => [
                'main' => \App\Support\SiteImage::urlFor('placeholder_facility'),
                'side_1' => \App\Support\SiteImage::urlFor('placeholder_team'),
                'side_2' => \App\Support\SiteImage::urlFor('placeholder_care'),
            ],
        ];

        $purpose = [
            'kicker' => SiteSetting::getValue('about.purpose.kicker', 'Purpose'),
            'heading' => SiteSetting::getValue('about.purpose.heading', 'Mission & Vision'),
            'mission' => [
                'kicker' => SiteSetting::getValue('about.purpose.mission.kicker', 'Mission'),
                'title' => SiteSetting::getValue('about.purpose.mission.title', 'A Christian community'),
                'body' => SiteSetting::getValue('about.purpose.mission.body', 'A Christian community committed to excellence in compassionate healthcare, spiritual ministry and training for service in the glory of God.'),
            ],
            'vision' => [
                'kicker' => SiteSetting::getValue('about.purpose.vision.kicker', 'Vision'),
                'title' => SiteSetting::getValue('about.purpose.vision.title', 'Christ-transformed health, lives and world'),
                'body' => SiteSetting::getValue('about.purpose.vision.body', 'Christ-transformed health, lives and world.'),
            ],
            'right' => [
                'kicker' => SiteSetting::getValue('about.purpose.right.kicker', 'Purpose Statement'),
                'title' => SiteSetting::getValue('about.purpose.right.title', 'Purpose Statement & Golden Rules'),
                'body' => SiteSetting::getValue('about.purpose.right.body', 'To glorify God through provision of holistic (physical, mental, emotional, social, and spiritual) patient- and family-centered cardiothoracic care.'),
                'image' => \App\Support\SiteImage::urlFor('about_purpose')
                    ?: \App\Support\SiteImage::urlFor('placeholder_care'),
            ],
        ];

        $metaDescription = 'Learn about the Cardiothoracic Centre at Tenwek Hospital: our mission, history, and commitment to advanced heart and chest care in East Africa.';

        $executiveBrochure = ResourceDownload::findBySlug('ctc-executive-brochure');

        return view('pages.about', compact('sections', 'coreValues', 'whoWeAre', 'purpose', 'metaDescription', 'executiveBrochure'));
    }

    public function history()
    {
        $milestones = HistoryMilestone::query()->visible()->ordered()->get();
        $galleryItems = HistoryGalleryItem::query()->visible()->ordered()->get();

        $metaDescription = 'The history of Tenwek Cardiothoracic Centre: key milestones, growth, and impact in expanding access to advanced cardiac care in Africa.';

        return view('pages.history', compact('milestones', 'galleryItems', 'metaDescription'));
    }

    public function specialists()
    {
        $team = TeamMember::visible()->ordered()->get([
            'id', 'name', 'slug', 'credentials', 'title', 'team_group', 'specialization', 'bio', 'photo', 'sort_order', 'is_visible',
        ]);
        $groupLabels = config('ctc.team_groups', []);

        $teamGroups = collect();
        foreach ($groupLabels as $key => $label) {
            $members = $team->where('team_group', $key)->values();
            if ($members->isNotEmpty()) {
                $teamGroups->put($key, [
                    'label' => $label,
                    'members' => $members,
                ]);
            }
        }

        $ungrouped = $team->filter(fn ($member) => blank($member->team_group))->values();
        if ($ungrouped->isNotEmpty()) {
            $teamGroups->put('other', [
                'label' => 'Our Team',
                'members' => $ungrouped,
            ]);
        }

        $metaDescription = 'Meet the cardiothoracic surgeons and specialist clinicians at Tenwek CTC, providing compassionate, safe, evidence-based heart and chest care.';

        return view('pages.specialists', compact('team', 'teamGroups', 'metaDescription'));
    }

    public function specialistShow(TeamMember $teamMember)
    {
        $metaDescription = $teamMember->bio
            ? str($teamMember->bio)->stripTags()->limit(160)
            : (($teamMember->specialization ?: $teamMember->title)
                ? ("Meet {$teamMember->name}, {$teamMember->title} at the Cardiothoracic Centre.")
                : "Meet {$teamMember->name} at the Cardiothoracic Centre.");

        $relatedBase = TeamMember::query()
            ->visible()
            ->where('id', '!=', $teamMember->id);

        $relatedColumns = ['id', 'name', 'slug', 'credentials', 'title', 'team_group', 'specialization', 'photo', 'sort_order', 'is_visible'];

        $related = (clone $relatedBase)
            ->when(filled($teamMember->team_group), fn ($q) => $q->where('team_group', $teamMember->team_group))
            ->ordered()
            ->take(6)
            ->get($relatedColumns);

        if ($related->count() < 6) {
            $related = $related->concat(
                (clone $relatedBase)
                    ->whereNotIn('id', $related->pluck('id'))
                    ->ordered()
                    ->take(6 - $related->count())
                    ->get($relatedColumns)
            )->values();
        }

        $pageTitle = $teamMember->name;

        return view('pages.specialist-show', compact('teamMember', 'related', 'metaDescription', 'pageTitle'));
    }

    public function services()
    {
        return $this->renderServicesPage(null);
    }

    public function servicesCategory(string $serviceCategory)
    {
        $map = [
            'cardiac-surgery' => Service::CATEGORY_CARDIAC,
            'thoracic-surgery' => Service::CATEGORY_THORACIC,
            'diagnostics' => Service::CATEGORY_DIAGNOSTICS,
        ];

        return $this->renderServicesPage($map[$serviceCategory] ?? abort(404));
    }

    private function renderServicesPage(?string $activeCategory)
    {
        $serviceColumns = ['id', 'name', 'slug', 'category', 'description', 'sort_order', 'is_visible', 'featured_image_path'];
        $empty = collect();

        $cardiac = (! $activeCategory || $activeCategory === Service::CATEGORY_CARDIAC)
            ? Service::visible()->inCategory(Service::CATEGORY_CARDIAC)->ordered()->get($serviceColumns)
            : $empty;
        $thoracic = (! $activeCategory || $activeCategory === Service::CATEGORY_THORACIC)
            ? Service::visible()->inCategory(Service::CATEGORY_THORACIC)->ordered()->get($serviceColumns)
            : $empty;
        $diagnostics = (! $activeCategory || $activeCategory === Service::CATEGORY_DIAGNOSTICS)
            ? Service::visible()->inCategory(Service::CATEGORY_DIAGNOSTICS)->ordered()->get($serviceColumns)
            : $empty;

        $categoryLabels = [
            Service::CATEGORY_CARDIAC => 'Cardiac Surgery',
            Service::CATEGORY_THORACIC => 'Thoracic Surgery',
            Service::CATEGORY_DIAGNOSTICS => 'Diagnostics',
        ];

        $categoryLabel = $activeCategory ? ($categoryLabels[$activeCategory] ?? null) : null;

        $defaultMeta = 'Compassionate, evidence-based cardiothoracic care at AGC Tenwek Cardiothoracic Centre — from consultation and diagnostics through surgery and long-term follow-up.';

        $metaByCategory = [
            Service::CATEGORY_CARDIAC => 'Cardiac surgery services at Tenwek CTC: adult and paediatric heart surgery, valve procedures, and congenital care with specialist teams.',
            Service::CATEGORY_THORACIC => 'Thoracic surgery at Tenwek CTC: lung, chest wall, and mediastinal procedures with evidence-based, patient-centered care.',
            Service::CATEGORY_DIAGNOSTICS => 'Diagnostics at Tenwek CTC: imaging and testing for accurate heart and chest diagnosis before treatment.',
        ];

        $metaDescription = $activeCategory
            ? ($metaByCategory[$activeCategory] ?? $defaultMeta)
            : $defaultMeta;

        $pageTitle = $categoryLabel
            ? $categoryLabel
            : 'Our Services';

        $activeServiceCategory = $activeCategory ? match ($activeCategory) {
            Service::CATEGORY_CARDIAC => 'cardiac-surgery',
            Service::CATEGORY_THORACIC => 'thoracic-surgery',
            Service::CATEGORY_DIAGNOSTICS => 'diagnostics',
            default => null,
        } : null;

        $categoryPage = $activeServiceCategory
            ? ServiceCategoryPage::query()->where('url_segment', $activeServiceCategory)->first()
            : null;

        if ($categoryPage) {
            $metaDescription = $categoryPage->meta_description;
            $pageTitle = $categoryPage->meta_title
                ?: ($categoryPage->intro_heading ?: $categoryLabel ?: 'Our Services');
        }

        $pageBannerKey = match ($activeCategory) {
            Service::CATEGORY_CARDIAC => 'services_cardiac',
            Service::CATEGORY_THORACIC => 'services_thoracic',
            Service::CATEGORY_DIAGNOSTICS => 'services_diagnostics',
            default => 'services',
        };

        $seoImage = $categoryPage?->featuredImageUrl()
            ?: \App\Support\PageBanner::urlFor($pageBannerKey);

        $servicesImageUrl = \App\Support\SiteImage::urlFor('home_services')
            ?: asset('service-home.webp');

        return view('pages.services', compact(
            'cardiac',
            'thoracic',
            'diagnostics',
            'activeCategory',
            'activeServiceCategory',
            'categoryLabel',
            'categoryPage',
            'metaDescription',
            'pageTitle',
            'pageBannerKey',
            'seoImage',
            'servicesImageUrl',
        ));
    }

    public function serviceShow(Service $service)
    {
        $related = Service::query()
            ->visible()
            ->inCategory($service->category)
            ->where('id', '!=', $service->id)
            ->ordered()
            ->take(6)
            ->get();

        $metaDescription = $service->description
            ? str($service->description)->stripTags()->limit(160)
            : ('Learn more about '.$service->name.' at the Cardiothoracic Centre, Tenwek Hospital.');

        $pageTitle = $service->name;

        return view('pages.service-show', compact('service', 'related', 'metaDescription', 'pageTitle'));
    }

    public function departmentShow(DepartmentPage $department)
    {
        if (! $department->is_visible) {
            abort(404);
        }

        $pageTitle = $department->meta_title ?: $department->intro_heading;
        $metaDescription = $department->meta_description;
        $seoImage = $department->featuredImageUrl()
            ?: \App\Support\PageBanner::urlFor('department_'.$department->url_segment);

        $relatedServiceSlugs = match ($department->url_segment) {
            'cardiology' => [
                'adult-cardiology',
                'pediatric-cardiology',
                'cardiac-catheterization-laboratory',
            ],
            'cardiothoracic-surgery' => [
                'cardiac-surgical-care',
                'thoracic-surgical-care',
                'intensive-care-unit',
                'cardiac-catheterization-laboratory',
                'pediatric-cardiology',
                'diagnostic-imaging',
            ],
            'endoscopy' => [
                'endoscopy',
                'diagnostic-imaging',
                'laboratory-services',
                'thoracic-surgical-care',
                'cardiac-surgical-care',
            ],
            'pharmacy' => [
                'adult-cardiology',
                'cardiac-surgical-care',
                'intensive-care-unit',
                'diagnostic-imaging',
                'laboratory-services',
            ],
            default => [],
        };

        $relatedServices = empty($relatedServiceSlugs)
            ? collect()
            : Service::query()
                ->visible()
                ->whereIn('slug', $relatedServiceSlugs)
                ->get()
                ->sortBy(fn (Service $service) => array_search($service->slug, $relatedServiceSlugs, true))
                ->values();

        $referralBlurb = match ($department->url_segment) {
            'cardiothoracic-surgery' => 'Referrals and appointments for cardiothoracic surgery are coordinated through the Centre.',
            'endoscopy' => 'Referrals and appointments for endoscopy are coordinated through the Centre. Call 0717 971 768 for Endoscopy enquiries.',
            'pharmacy' => 'Pharmacy enquiries: +254 114 704 534. Referrals for complex medication management are coordinated through the Centre.',
            default => 'Referrals and appointments for this department are coordinated through the Centre.',
        };

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Services', 'url' => route('services')],
            ['label' => $department->intro_heading, 'url' => route('departments.show', $department)],
        ];

        return view('pages.department-show', compact(
            'department',
            'pageTitle',
            'metaDescription',
            'seoImage',
            'breadcrumbs',
            'relatedServices',
            'referralBlurb',
        ));
    }

    public function patientInformation()
    {
        return view('pages.patient-information');
    }

    public function training()
    {
        $metaDescription = 'Education and training at AGC Tenwek Cardiothoracic Centre: shaping the future of cardiothoracic care through fellowship and perfusion programmes.';

        return view('pages.training', compact('metaDescription'));
    }

    public function research()
    {
        return view('pages.research');
    }

    public function trainingFellowshipRotations()
    {
        $metaDescription = 'Cardiothoracic Surgery Fellowship at AGC Tenwek Cardiothoracic Centre through PAACS in collaboration with COSECSA.';

        return view('pages.training-fellowship-rotations', compact('metaDescription'));
    }

    public function trainingPerfusion()
    {
        $metaDescription = 'Cardiovascular Perfusion Training Program at AGC Tenwek Cardiothoracic Centre: classroom, simulation, and clinical experience for open-heart surgery support.';

        return view('pages.training-perfusion', compact('metaDescription'));
    }

    public function trainingMedicalEducation()
    {
        $metaDescription = 'Medical education at AGC Tenwek Cardiothoracic Centre: COSECSA cardiothoracic surgery fellowship, perfusion training, anaesthesia rotations, and clinical learning grounded in excellence and Christian discipleship.';

        return view('pages.training-medical-education', compact('metaDescription'));
    }

    public function researchPublications()
    {
        $metaDescription = 'Publications from Tenwek Cardiothoracic Centre: peer-reviewed articles, conference presentations, and outcomes research in resource-limited settings.';

        return view('pages.research-publications', compact('metaDescription'));
    }

    public function trainingResearch()
    {
        $collegeWebsiteUrl = SiteSetting::getValue('external.college_website_url', config('ctc.college_website.url'));
        $collegeWebsiteUrl = is_string($collegeWebsiteUrl) && filter_var($collegeWebsiteUrl, FILTER_VALIDATE_URL)
            ? $collegeWebsiteUrl
            : null;

        $collegeLabelStored = SiteSetting::getValue('external.college_website_label');
        $collegeWebsiteLabel = (is_string($collegeLabelStored) && $collegeLabelStored !== '')
            ? $collegeLabelStored
            : (string) config('ctc.college_website.label');

        return view('pages.training-research', compact('collegeWebsiteUrl', 'collegeWebsiteLabel'));
    }

    public function impact()
    {
        $allStories = ImpactStory::query()->visible()->ordered()->get();
        $featuredStory = $allStories->firstWhere('is_featured', true);
        $stories = $allStories
            ->when($featuredStory, fn ($c) => $c->where('id', '!=', $featuredStory->id))
            ->take(6)
            ->values();

        $latestNews = NewsArticle::published()->latest()->take(3)->get([
            'id', 'title', 'slug', 'type', 'excerpt', 'featured_image', 'published_at', 'is_published', 'created_at',
        ]);

        $feature = $featuredStory;
        if ($feature && ! $feature->media_url && ! $feature->image_url) {
            $feature = null;
        }
        if (! $feature) {
            $feature = $allStories->first(function ($story) {
                return filled($story->media_url)
                    || filled($story->image_path ?? null)
                    || filled($story->image ?? null)
                    || filled($story->image_url ?? null);
            });
        }

        $testimonials = ImpactTestimonial::query()->visible()->ordered()->get();

        $metaDescription = 'Impact of Tenwek CTC across Africa: patient stories, milestones, training the next generation of surgeons, and expanding access to life-saving care.';

        return view('pages.impact', compact(
            'stories',
            'latestNews',
            'feature',
            'featuredStory',
            'testimonials',
            'metaDescription',
        ));
    }

    public function support()
    {
        $metaDescription = 'Support Tenwek CTC through donations, sponsoring surgeries, and helping equip life-saving cardiothoracic care for patients across the region.';

        return view('pages.support', compact('metaDescription'));
    }

    public function news()
    {
        $listColumns = ['id', 'title', 'slug', 'type', 'excerpt', 'featured_image', 'published_at', 'is_published', 'created_at', 'updated_at'];
        $articles = NewsArticle::query()->published()->where('type', '!=', NewsArticle::TYPE_EVENT)->latest()->paginate(9, $listColumns);
        $recent = NewsArticle::query()->published()->where('type', '!=', NewsArticle::TYPE_EVENT)->latest()->take(12)->get($listColumns);

        $metaDescription = 'News, events, and announcements from the Cardiothoracic Centre at Tenwek Hospital.';

        return view('pages.news', compact('articles', 'recent', 'metaDescription'));
    }

    public function newsShow(string $slug)
    {
        $article = NewsArticle::query()
            ->published()
            ->where('type', '!=', NewsArticle::TYPE_EVENT)
            ->where('slug', $slug)
            ->firstOrFail();

        $recent = NewsArticle::query()
            ->published()
            ->where('type', '!=', NewsArticle::TYPE_EVENT)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(12)
            ->get(['id', 'title', 'slug', 'type', 'excerpt', 'featured_image', 'published_at', 'is_published', 'created_at']);

        $metaDescription = $article->excerpt
            ? str($article->excerpt)->stripTags()->limit(160)
            : str($article->body ?? '')->stripTags()->limit(160);

        $seoSchema = [[
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => $metaDescription,
            'datePublished' => optional($article->published_at ?? $article->created_at)->toIso8601String(),
            'dateModified' => optional($article->updated_at ?? $article->published_at ?? $article->created_at)->toIso8601String(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current(),
            ],
            'image' => array_values(array_filter([$article->featured_image_url])),
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('ctc.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => url('/ctc.jpg'),
                ],
            ],
        ]];

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'News & Media', 'url' => route('news')],
            ['label' => $article->title, 'url' => url()->current()],
        ];

        $seoImage = $article->featured_image_url;
        $pageTitle = $article->title;

        return view('pages.news-show', compact('article', 'recent', 'metaDescription', 'seoSchema', 'breadcrumbs', 'seoImage', 'pageTitle'));
    }

    public function gallery()
    {
        $items = GalleryItem::query()->published()->ordered()->get();
        $groups = \App\Support\GalleryAlbums::buildGroups($items);
        $rows = \App\Support\GalleryAlbums::packRows($groups);

        $metaDescription = 'Photo gallery from the Cardiothoracic Centre at Tenwek Hospital: care, facility, and community.';

        return view('pages.gallery', compact('items', 'groups', 'rows', 'metaDescription'));
    }

    public function events()
    {
        $listColumns = ['id', 'title', 'slug', 'type', 'excerpt', 'body', 'featured_image', 'event_date', 'published_at', 'is_published', 'created_at', 'updated_at'];
        $events = NewsArticle::query()->published()->events()->latest('event_date')->latest()->paginate(9, $listColumns);
        $recent = NewsArticle::query()->published()->events()->latest('event_date')->latest()->take(12)->get($listColumns);

        $metaDescription = 'Upcoming and recent events from the Cardiothoracic Centre at Tenwek Hospital.';

        return view('pages.events', compact('events', 'recent', 'metaDescription'));
    }

    public function eventShow(string $slug)
    {
        $event = NewsArticle::query()
            ->published()
            ->events()
            ->where('slug', $slug)
            ->firstOrFail();

        $recent = NewsArticle::query()
            ->published()
            ->events()
            ->where('id', '!=', $event->id)
            ->latest('event_date')
            ->latest()
            ->take(12)
            ->get(['id', 'title', 'slug', 'type', 'excerpt', 'featured_image', 'event_date', 'published_at', 'is_published', 'created_at']);

        $metaDescription = $event->excerpt
            ? str($event->excerpt)->stripTags()->limit(160)
            : str($event->body ?? '')->stripTags()->limit(160);

        $seoSchema = [[
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->title,
            'description' => $metaDescription,
            'startDate' => optional($event->event_date ?? $event->published_at ?? $event->created_at)->toIso8601String(),
            'eventStatus' => 'https://schema.org/EventScheduled',
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
            'image' => array_values(array_filter([$event->featured_image_url])),
            'organizer' => [
                '@type' => 'Organization',
                'name' => config('ctc.name'),
            ],
            'location' => [
                '@type' => 'Place',
                'name' => config('ctc.hospital'),
                'address' => config('ctc.contact.address'),
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current(),
            ],
        ]];

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Events', 'url' => route('events')],
            ['label' => $event->title, 'url' => url()->current()],
        ];

        $seoImage = $event->featured_image_url;
        $pageTitle = $event->title;
        $article = $event;

        return view('pages.events-show', compact('event', 'article', 'recent', 'metaDescription', 'seoSchema', 'breadcrumbs', 'seoImage', 'pageTitle'));
    }

    public function contact()
    {
        $contact = ContactSetting::current();

        $a = random_int(2, 9);
        $b = random_int(1, 9);
        session([
            'contact_math_a' => $a,
            'contact_math_b' => $b,
        ]);

        $metaDescription = 'Contact Tenwek Cardiothoracic Centre for general enquiries and messages. To request an appointment, use the Book appointment page.';

        return view('pages.contact', [
            'contact' => $contact,
            'metaDescription' => $metaDescription,
            'mathA' => $a,
            'mathB' => $b,
        ]);
    }

    public function bookAppointment()
    {
        $contact = ContactSetting::current();

        $a = random_int(2, 9);
        $b = random_int(1, 9);
        session([
            'booking_math_a' => $a,
            'booking_math_b' => $b,
        ]);

        $metaDescription = 'Request an appointment or consultation at Tenwek Cardiothoracic Centre. Our team will review your details and contact you to coordinate next steps.';

        return view('pages.book-appointment', [
            'contact' => $contact,
            'metaDescription' => $metaDescription,
            'mathA' => $a,
            'mathB' => $b,
        ]);
    }

    public function submitBooking(Request $request)
    {
        if (! empty($request->input('website'))) {
            return redirect()
                ->route('book-appointment')
                ->with('success', 'Thank you. We have received your request and will be in touch soon.');
        }

        $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'type' => ['required', 'string', 'in:appointment,consultation'],
            'requested_date' => ['nullable', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:4000'],
            'math_answer' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $a = (int) session('booking_math_a');
        $b = (int) session('booking_math_b');
        $expected = $a + $b;
        if (! $a || ! $b || (int) $request->input('math_answer') !== $expected) {
            return back()
                ->withErrors(['math_answer' => 'Please answer the anti-spam question correctly.'])
                ->withInput();
        }

        Booking::query()->create([
            'patient_name' => $request->input('patient_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone') ?: null,
            'requested_date' => $request->input('requested_date') ?: null,
            'status' => Booking::STATUS_PENDING,
            'type' => $request->input('type'),
            'notes' => $request->input('notes') ?: null,
        ]);

        $request->session()->forget(['booking_math_a', 'booking_math_b']);

        return redirect()
            ->route('book-appointment')
            ->with('success', 'Thank you. Your appointment request has been submitted. Our team will contact you to confirm or suggest alternative dates.');
    }

    public function internationalPatients()
    {
        $contact = ContactSetting::current();
        $metaDescription = 'International patient care at Tenwek Cardiothoracic Centre: referrals, medical records, travel planning, arrival, and dedicated coordination, with world-class cardiothoracic care in Kenya.';

        return view('pages.international-patients', compact('contact', 'metaDescription'));
    }

    public function privacyPolicy()
    {
        $bodyHtml = LegalPageContent::resolvedBody('legal.privacy.body');

        return view('pages.privacy-policy', compact('bodyHtml'));
    }

    public function termsOfService()
    {
        $bodyHtml = LegalPageContent::resolvedBody('legal.terms.body');

        return view('pages.terms-of-service', compact('bodyHtml'));
    }

    public function feedbackAndComplaints()
    {
        $a = random_int(2, 9);
        $b = random_int(1, 9);
        session([
            'feedback_math_a' => $a,
            'feedback_math_b' => $b,
        ]);

        return view('pages.feedback-and-complaints', [
            'mathA' => $a,
            'mathB' => $b,
        ]);
    }

    public function submitFeedbackAndComplaints(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required|string|in:feedback,complaint',
            'message' => 'required|string|max:5000',
            'math_answer' => 'required|integer|min:0|max:100',
        ]);

        $a = (int) session('feedback_math_a');
        $b = (int) session('feedback_math_b');
        $expected = $a + $b;
        if (! $a || ! $b || (int) $request->input('math_answer') !== $expected) {
            return back()
                ->withErrors(['math_answer' => 'Please answer the anti-spam question correctly.'])
                ->withInput();
        }

        ContactEnquiry::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => ucfirst($request->input('type')).' submission',
            'message' => $request->input('message'),
            'source' => $request->input('type') === 'complaint' ? 'complaint' : 'feedback',
            'status' => ContactEnquiry::STATUS_NEW,
        ]);

        $request->session()->forget(['feedback_math_a', 'feedback_math_b']);

        return redirect()
            ->route('feedback')
            ->with('success', 'Thank you. Your submission has been received.');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:5000',
            'website' => 'nullable|string|max:255',
            'math_answer' => 'required|integer|min:0|max:100',
        ]);

        // Honeypot: if filled, silently accept without storing.
        if (! empty($request->input('website'))) {
            return redirect()
                ->route('contact')
                ->with('success', 'Thank you. We have received your message and will get back to you soon.');
        }

        $a = (int) session('contact_math_a');
        $b = (int) session('contact_math_b');
        $expected = $a + $b;
        if (! $a || ! $b || (int) $request->input('math_answer') !== $expected) {
            return back()
                ->withErrors(['math_answer' => 'Please answer the anti-spam question correctly.'])
                ->withInput();
        }

        ContactEnquiry::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => 'Contact form',
            'message' => $request->input('message'),
            'source' => 'contact',
        ]);

        $request->session()->forget(['contact_math_a', 'contact_math_b']);

        return redirect()->route('contact')->with('success', 'Thank you. We have received your message and will get back to you soon.');
    }

    public function submitSupportEnquiry(Request $request)
    {
        // Honeypot spam protection: if filled, silently accept but ignore.
        if (! empty($request->input('website'))) {
            return redirect()->route('support')->with('success', 'Thank you. We have received your enquiry and will be in touch soon.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'enquiry_type' => 'required|string|in:sponsor,equipment,partner',
            'message' => 'required|string|max:5000',
        ]);
        ContactEnquiry::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => 'Support: '.$request->input('enquiry_type'),
            'message' => $request->input('message'),
            'source' => 'support-'.$request->input('enquiry_type'),
        ]);

        return redirect()->route('support')->with('success', 'Thank you. We have received your enquiry and will be in touch soon.');
    }
}
