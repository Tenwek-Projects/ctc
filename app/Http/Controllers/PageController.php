<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Booking;
use App\Models\ContactEnquiry;
use App\Models\ContactSetting;
use App\Models\CoreValue;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\HistoryMilestone;
use App\Models\HomeStat;
use App\Models\ImpactStory;
use App\Models\ImpactTestimonial;
use App\Models\NewsArticle;
use App\Models\Service;
use App\Models\ServiceCategoryPage;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\TrainingProgram;
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

        $services = Service::visible()->ordered()->take(8)->get();
        $team = TeamMember::visible()->ordered()->take(4)->get();
        $news = NewsArticle::published()->latest()->take(3)->get();

        $heroMode = SiteSetting::getValue('hero.mode', 'video');
        $heroTitle = SiteSetting::getValue('hero.title', 'Cardiothoracic Centre');
        $heroSubtitle = SiteSetting::getValue('hero.subtitle', 'Tenwek Hospital');
        $heroDescription = SiteSetting::getValue('hero.description', 'A beacon of hope and healing for patients with heart disease across Sub‑Saharan Africa. We provide life‑saving open‑heart and thoracic care, and train African healthcare professionals to expand access to treatment.');
        $heroVideoPath = SiteSetting::getValue('hero.video_path');
        $heroVideoUrl = $heroVideoPath
            ? PublicAssetUrl::toUrl($heroVideoPath)
            : SiteSetting::getValue('hero.video_url', config('ctc.hero_video'));
        $heroSlides = HeroSlide::query()->visible()->ordered()->get();
        $servicesImagePath = SiteSetting::getValue('home.services_image_path');
        $servicesImageUrl = PublicAssetUrl::toUrl($servicesImagePath);

        $impactImageUrl = ImpactStory::query()
            ->visible()
            ->ordered()
            ->whereNotNull('image')
            ->value('image');

        $impactImageUrl = $impactImageUrl ?: config('ctc.page_banner_image');

        return view('pages.home', compact(
            'stats',
            'services',
            'team',
            'news',
            'heroMode',
            'heroTitle',
            'heroSubtitle',
            'heroDescription',
            'heroVideoUrl',
            'heroSlides',
            'servicesImageUrl',
            'impactImageUrl'
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
                'main' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.who_we_are.image_main_path')),
                'side_1' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.who_we_are.image_side_1_path')),
                'side_2' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.who_we_are.image_side_2_path')),
            ],
        ];

        $purpose = [
            'kicker' => SiteSetting::getValue('about.purpose.kicker', 'Purpose'),
            'heading' => SiteSetting::getValue('about.purpose.heading', 'Mission & Vision'),
            'mission' => [
                'kicker' => SiteSetting::getValue('about.purpose.mission.kicker', 'Mission'),
                'title' => SiteSetting::getValue('about.purpose.mission.title', 'Excellent, compassionate care'),
                'body' => SiteSetting::getValue('about.purpose.mission.body', 'To provide excellent, compassionate cardiothoracic care to all who need it, and to train the next generation of surgeons and healthcare workers for Africa.'),
            ],
            'vision' => [
                'kicker' => SiteSetting::getValue('about.purpose.vision.kicker', 'Vision'),
                'title' => SiteSetting::getValue('about.purpose.vision.title', 'Access for every patient'),
                'body' => SiteSetting::getValue('about.purpose.vision.body', 'A region where every person has access to life‑saving heart and chest surgery, delivered by well‑trained local teams.'),
            ],
            'right' => [
                'kicker' => SiteSetting::getValue('about.purpose.right.kicker', 'How we work'),
                'title' => SiteSetting::getValue('about.purpose.right.title', 'What patients can expect'),
                'body' => SiteSetting::getValue('about.purpose.right.body', 'Clear communication, safety-first protocols, and coordinated care from referral through recovery.'),
                'image' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.purpose.right.image_path')),
            ],
        ];

        $metaDescription = 'Learn about the Cardiothoracic Centre at Tenwek Hospital: our mission, history, and commitment to advanced heart and chest care in East Africa.';

        return view('pages.about', compact('sections', 'coreValues', 'whoWeAre', 'purpose', 'metaDescription'));
    }

    public function history()
    {
        $milestones = HistoryMilestone::query()->visible()->ordered()->get();

        $metaDescription = 'The history of Tenwek Cardiothoracic Centre: key milestones, growth, and impact in expanding access to advanced cardiac care in Africa.';

        return view('pages.history', compact('milestones', 'metaDescription'));
    }

    public function specialists()
    {
        $team = TeamMember::visible()->ordered()->get();

        return view('pages.specialists', compact('team'));
    }

    public function specialistShow(TeamMember $teamMember)
    {
        $metaDescription = $teamMember->bio
            ? str($teamMember->bio)->stripTags()->limit(160)
            : (($teamMember->specialization ?: $teamMember->title) ? ("Meet {$teamMember->name}, {$teamMember->title} at Tenwek Cardiothoracic Centre.") : "Meet {$teamMember->name} at Tenwek Cardiothoracic Centre.");

        $related = TeamMember::query()
            ->visible()
            ->where('id', '!=', $teamMember->id)
            ->ordered()
            ->take(6)
            ->get();

        return view('pages.specialist-show', compact('teamMember', 'related', 'metaDescription'));
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
        $cardiac = Service::visible()->inCategory(Service::CATEGORY_CARDIAC)->ordered()->get();
        $thoracic = Service::visible()->inCategory(Service::CATEGORY_THORACIC)->ordered()->get();
        $diagnostics = Service::visible()->inCategory(Service::CATEGORY_DIAGNOSTICS)->ordered()->get();

        $categoryLabels = [
            Service::CATEGORY_CARDIAC => 'Cardiac Surgery',
            Service::CATEGORY_THORACIC => 'Thoracic Surgery',
            Service::CATEGORY_DIAGNOSTICS => 'Diagnostics',
        ];

        $categoryLabel = $activeCategory ? ($categoryLabels[$activeCategory] ?? null) : null;

        $defaultMeta = 'Explore cardiothoracic services at Tenwek CTC: cardiac surgery, thoracic surgery, and diagnostics, with patient-centered care and specialist expertise.';

        $metaByCategory = [
            Service::CATEGORY_CARDIAC => 'Cardiac surgery services at Tenwek CTC: adult and paediatric heart surgery, valve procedures, and congenital care with specialist teams.',
            Service::CATEGORY_THORACIC => 'Thoracic surgery at Tenwek CTC: lung, chest wall, and mediastinal procedures with evidence-based, patient-centered care.',
            Service::CATEGORY_DIAGNOSTICS => 'Diagnostics at Tenwek CTC: imaging and testing for accurate heart and chest diagnosis before treatment.',
        ];

        $metaDescription = $activeCategory
            ? ($metaByCategory[$activeCategory] ?? $defaultMeta)
            : $defaultMeta;

        $pageTitle = $categoryLabel
            ? ($categoryLabel.' | '.config('ctc.name'))
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
                ?: (($categoryPage->intro_heading ?: $categoryLabel).' | '.config('ctc.name'));
        }

        $pageBannerKey = match ($activeCategory) {
            Service::CATEGORY_CARDIAC => 'services_cardiac',
            Service::CATEGORY_THORACIC => 'services_thoracic',
            Service::CATEGORY_DIAGNOSTICS => 'services_diagnostics',
            default => 'services',
        };

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
            : ('Learn more about '.$service->name.' at Tenwek Cardiothoracic Centre.');

        return view('pages.service-show', compact('service', 'related', 'metaDescription'));
    }

    public function patientInformation()
    {
        return view('pages.patient-information');
    }

    public function training()
    {
        $programs = TrainingProgram::query()->visible()->ordered()->get();

        $metaDescription = 'Training at Tenwek CTC: fellowship, rotations, visiting surgeons programme, and medical student placements, building cardiothoracic capacity for Africa.';

        return view('pages.training', compact('programs', 'metaDescription'));
    }

    public function research()
    {
        return view('pages.research');
    }

    public function trainingFellowshipRotations()
    {
        $metaDescription = 'Fellowship and rotations at Tenwek CTC: supervised clinical training in adult and paediatric cardiac surgery, thoracic surgery, and perioperative care in East Africa.';

        return view('pages.training-fellowship-rotations', compact('metaDescription'));
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
        $featuredStory = ImpactStory::query()->visible()->where('is_featured', true)->ordered()->first();

        $storiesQuery = ImpactStory::query()->visible()->ordered();
        if ($featuredStory) {
            $storiesQuery->where('id', '!=', $featuredStory->id);
        }
        $stories = $storiesQuery->take(6)->get();

        $latestNews = NewsArticle::published()->latest()->take(3)->get();

        $feature = $featuredStory;
        if ($feature && ! $feature->media_url && ! $feature->image_url) {
            $feature = null;
        }
        if (! $feature) {
            $feature = ImpactStory::query()
                ->visible()
                ->ordered()
                ->where(function ($q) {
                    $q->whereNotNull('media_url')->orWhereNotNull('image_path')->orWhereNotNull('image');
                })
                ->first();
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
        return view('pages.support');
    }

    public function news()
    {
        $articles = NewsArticle::published()->latest()->paginate(9);
        $recent = NewsArticle::query()->published()->latest()->take(12)->get();

        $metaDescription = 'News, events, and announcements from the Cardiothoracic Centre at Tenwek Hospital.';

        return view('pages.news', compact('articles', 'recent', 'metaDescription'));
    }

    public function newsShow(string $slug)
    {
        $article = NewsArticle::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recent = NewsArticle::query()
            ->published()
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(12)
            ->get();

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

        return view('pages.news-show', compact('article', 'recent', 'metaDescription', 'seoSchema', 'breadcrumbs', 'seoImage'));
    }

    public function gallery()
    {
        $items = GalleryItem::query()->published()->ordered()->get();

        $metaDescription = 'Photo gallery from the Cardiothoracic Centre at Tenwek Hospital: care, facility, and community.';

        return view('pages.gallery', compact('items', 'metaDescription'));
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
