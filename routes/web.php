<?php

use App\Http\Controllers\Admin\AboutIntroController;
use App\Http\Controllers\Admin\AboutPurposeController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CollegeWebsiteController;
use App\Http\Controllers\Admin\ContactEnquiryController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\CoreValueController;
use App\Http\Controllers\Admin\CollegeApplicationAdminController;
use App\Http\Controllers\Admin\DangerZoneController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentPageController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\EventArticleController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\HistoryGalleryItemController;
use App\Http\Controllers\Admin\HistoryMilestoneController;
use App\Http\Controllers\Admin\HomeStatController;
use App\Http\Controllers\Admin\ImpactStoryController;
use App\Http\Controllers\Admin\ImpactTestimonialController;
use App\Http\Controllers\Admin\LegalPageController;
use App\Http\Controllers\Admin\NewsArticleController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\SiteImageController;
use App\Http\Controllers\Admin\PatientInfoController;
use App\Http\Controllers\Admin\ResearchPublicationController;
use App\Http\Controllers\Admin\ServiceCategoryPageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SocialLinksController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TwoFactorSettingsController;
use App\Http\Controllers\Admin\TrainingProgramController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CollegeApplicationController;
use App\Http\Controllers\ResourceDownloadController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemaps/pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemaps/news.xml', [SitemapController::class, 'news'])->name('sitemap.news');
Route::get('/sitemaps/services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/sitemaps/specialists.xml', [SitemapController::class, 'specialists'])->name('sitemap.specialists');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots.txt');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/downloads/{slug}', [ResourceDownloadController::class, 'download'])
    ->name('downloads.show')
    ->middleware('throttle:30,1');
Route::get('/history', [PageController::class, 'history'])->name('history');
Route::get('/specialists', [PageController::class, 'specialists'])->name('specialists');
Route::get('/specialists/{teamMember}', [PageController::class, 'specialistShow'])->name('specialists.show');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{serviceCategory}', [PageController::class, 'servicesCategory'])
    ->whereIn('serviceCategory', ['cardiac-surgery', 'thoracic-surgery', 'diagnostics'])
    ->name('services.category');
Route::get('/services/{service}', [PageController::class, 'serviceShow'])->name('services.show');
Route::get('/departments/{department}', [PageController::class, 'departmentShow'])->name('departments.show');
Route::get('/patient-information', [PageController::class, 'patientInformation'])->name('patient-information');
Route::get('/international-patients', [PageController::class, 'internationalPatients'])->name('international-patients');
Route::get('/training-research', [PageController::class, 'trainingResearch'])->name('training-research');
Route::get('/training', [PageController::class, 'training'])->name('training');
Route::get('/training/fellowship-and-rotations', [PageController::class, 'trainingFellowshipRotations'])->name('training.fellowship-rotations');
Route::get('/training/cardiovascular-perfusion', [PageController::class, 'trainingPerfusion'])->name('training.perfusion');
Route::get('/research', [PageController::class, 'research'])->name('research');
Route::get('/research/publications', [PageController::class, 'researchPublications'])->name('research.publications');
Route::get('/impact', [PageController::class, 'impact'])->name('impact');
Route::get('/support', [PageController::class, 'support'])->name('support');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/events', [PageController::class, 'events'])->name('events');
Route::get('/events/{slug}', [PageController::class, 'eventShow'])->name('events.show');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:10,1');
Route::get('/book-appointment', [PageController::class, 'bookAppointment'])->name('book-appointment');
Route::post('/book-appointment', [PageController::class, 'submitBooking'])->name('book-appointment.submit')->middleware('throttle:10,1');
Route::post('/support-enquiry', [PageController::class, 'submitSupportEnquiry'])->name('support.enquiry.submit');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms-of-service');
Route::get('/feedback-and-complaints', [PageController::class, 'feedbackAndComplaints'])->name('feedback');
Route::post('/feedback-and-complaints', [PageController::class, 'submitFeedbackAndComplaints'])->name('feedback.submit');

// College applications (token-based secure access, draft resume)
Route::get('/college/apply', [CollegeApplicationController::class, 'landing'])->name('college.apply.landing');
Route::post('/college/apply/start', [CollegeApplicationController::class, 'start'])->name('college.apply.start')->middleware('throttle:20,1');
Route::get('/college/apply/{application}', [CollegeApplicationController::class, 'show'])->name('college.apply.show');
Route::post('/college/apply/{application}/draft', [CollegeApplicationController::class, 'saveDraft'])->name('college.apply.save-draft')->middleware('throttle:60,1');
Route::post('/college/apply/{application}/documents', [CollegeApplicationController::class, 'uploadDocument'])->name('college.apply.upload-document')->middleware('throttle:30,1');
Route::get('/college/apply/{application}/documents/{document}', [CollegeApplicationController::class, 'previewDocument'])->name('college.apply.document.preview');
Route::post('/college/apply/{application}/submit', [CollegeApplicationController::class, 'submit'])->name('college.apply.submit')->middleware('throttle:10,1');
Route::get('/college/apply/{application}/success', [CollegeApplicationController::class, 'success'])->name('college.apply.success');
Route::get('/college/apply/{application}/dashboard', [CollegeApplicationController::class, 'dashboard'])->name('college.apply.dashboard');

// Admin dashboard (role-based: only admin roles can access)
Route::get('/login', fn () => redirect()->route('admin-dashboard.login'))->name('login');
Route::get('admin-dashboard/login', [LoginController::class, 'showLoginForm'])->name('admin-dashboard.login');
Route::post('admin-dashboard/login', [LoginController::class, 'login'])->name('admin-dashboard.login.attempt');
Route::get('admin-dashboard/two-factor', [LoginController::class, 'showTwoFactorForm'])->name('admin-dashboard.two-factor');
Route::post('admin-dashboard/two-factor', [LoginController::class, 'verifyTwoFactor'])->name('admin-dashboard.two-factor.verify');
Route::post('admin-dashboard/two-factor/resend', [LoginController::class, 'resendTwoFactor'])->name('admin-dashboard.two-factor.resend');
Route::post('admin-dashboard/logout', [LoginController::class, 'logout'])->name('admin-dashboard.logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin-dashboard')->name('admin-dashboard.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::get('about-intro', [AboutIntroController::class, 'edit'])->name('about-intro.edit');
    Route::put('about-intro', [AboutIntroController::class, 'update'])->name('about-intro.update');

    Route::get('about-purpose', [AboutPurposeController::class, 'edit'])->name('about-purpose.edit');
    Route::put('about-purpose', [AboutPurposeController::class, 'update'])->name('about-purpose.update');

    Route::get('contact-settings', [ContactSettingController::class, 'edit'])->name('contact-settings.edit');
    Route::put('contact-settings', [ContactSettingController::class, 'update'])->name('contact-settings.update');

    Route::get('legal-pages', [LegalPageController::class, 'index'])->name('legal-pages.index');
    Route::get('legal-pages/{page}', [LegalPageController::class, 'edit'])->where('page', 'privacy|terms')->name('legal-pages.edit');
    Route::put('legal-pages/{page}', [LegalPageController::class, 'update'])->where('page', 'privacy|terms')->name('legal-pages.update');

    Route::get('site-images', [SiteImageController::class, 'index'])->name('site-images.index');
    Route::post('site-images/{key}', [SiteImageController::class, 'update'])->name('site-images.update');
    Route::delete('site-images/{key}', [SiteImageController::class, 'destroy'])->name('site-images.destroy');

    Route::get('page-banners', [PageBannerController::class, 'index'])->name('page-banners.index');
    Route::post('page-banners/{key}', [PageBannerController::class, 'update'])->name('page-banners.update');
    Route::delete('page-banners/{key}', [PageBannerController::class, 'destroy'])->name('page-banners.destroy');

    Route::get('hero', [HeroController::class, 'edit'])->name('hero.edit');
    Route::put('hero', [HeroController::class, 'update'])->name('hero.update');
    Route::put('hero/services-image', [HeroController::class, 'updateServicesImage'])->name('hero.services-image.update');
    Route::post('hero/slides', [HeroController::class, 'storeSlide'])->name('hero.slides.store');
    Route::put('hero/slides/{heroSlide}', [HeroController::class, 'updateSlide'])->name('hero.slides.update');
    Route::delete('hero/slides/{heroSlide}', [HeroController::class, 'destroySlide'])->name('hero.slides.destroy');

    Route::get('home-stats', [HomeStatController::class, 'index'])->name('home-stats.index');
    Route::post('home-stats', [HomeStatController::class, 'store'])->name('home-stats.store');
    Route::put('home-stats/{homeStat}', [HomeStatController::class, 'update'])->name('home-stats.update');
    Route::delete('home-stats/{homeStat}', [HomeStatController::class, 'destroy'])->name('home-stats.destroy');

    Route::resource('core-values', CoreValueController::class)->except('show')->parameters(['core-values' => 'core_value']);
    Route::resource('about', AboutSectionController::class)->except('show')->parameters(['about' => 'about_section']);
    Route::middleware('permission:team.manage')->group(function (): void {
        Route::resource('team-members', TeamMemberController::class)->except('show');
        Route::post('team-members/{team_member}/photo', [TeamMemberController::class, 'updatePhoto'])
            ->whereNumber('team_member')
            ->name('team-members.photo');
        Route::patch('team-members/{team_member}/homepage', [TeamMemberController::class, 'toggleHomepage'])
            ->whereNumber('team_member')
            ->name('team-members.homepage');
        Route::patch('team-members/{team_member}/reorder', [TeamMemberController::class, 'reorder'])
            ->whereNumber('team_member')
            ->name('team-members.reorder');
    });
    Route::middleware('permission:services.manage')->group(function (): void {
        Route::patch('services/reorder', [ServiceController::class, 'reorder'])
            ->name('services.reorder');
        Route::patch('services/{service}/homepage', [ServiceController::class, 'toggleHomepage'])
            ->whereNumber('service')
            ->name('services.homepage');
        Route::resource('services', ServiceController::class)->except('show');
        Route::get('service-category-pages', [ServiceCategoryPageController::class, 'index'])->name('service-category-pages.index');
        Route::get('service-category-pages/{serviceCategoryPage}/edit', [ServiceCategoryPageController::class, 'edit'])->name('service-category-pages.edit');
        Route::put('service-category-pages/{serviceCategoryPage}', [ServiceCategoryPageController::class, 'update'])->name('service-category-pages.update');
        Route::get('department-pages', [DepartmentPageController::class, 'index'])->name('department-pages.index');
        Route::get('department-pages/{departmentPage}/edit', [DepartmentPageController::class, 'edit'])->name('department-pages.edit');
        Route::put('department-pages/{departmentPage}', [DepartmentPageController::class, 'update'])->name('department-pages.update');
    });
    Route::resource('patient-info', PatientInfoController::class)->except('show')->parameters(['patient_info' => 'patient_info_block']);
    Route::resource('training', TrainingProgramController::class)->except('show');
    Route::resource('research', ResearchPublicationController::class)->except('show')->parameters(['research' => 'research_publication']);
    Route::resource('impact', ImpactStoryController::class)->except('show')->parameters(['impact' => 'impact_story']);
    Route::resource('impact-testimonials', ImpactTestimonialController::class)->except('show');
    Route::resource('history-milestones', HistoryMilestoneController::class)->except('show')->parameters(['history_milestones' => 'history_milestone']);
    Route::resource('history-gallery', HistoryGalleryItemController::class)->except('show')->parameters(['history-gallery' => 'history_gallery']);
    Route::resource('donations', DonationController::class)->except('show');
    Route::middleware('permission:news.manage')->group(function (): void {
        Route::resource('news', NewsArticleController::class)->except('show');
        Route::resource('events', EventArticleController::class)->except('show')->parameters(['events' => 'event_article']);
    });
    Route::get('gallery/albums/{album}', [GalleryItemController::class, 'album'])->name('gallery.album');
    Route::patch('gallery/albums/{album}/reorder', [GalleryItemController::class, 'reorderAlbum'])->name('gallery.albums.reorder');
    Route::patch('gallery/{gallery_item}/reorder', [GalleryItemController::class, 'reorderItem'])->name('gallery.items.reorder');
    Route::resource('gallery', GalleryItemController::class)->except('show')->parameters(['gallery' => 'gallery_item']);
    Route::resource('enquiries', ContactEnquiryController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('bookings', BookingController::class)->except('show');
    Route::get('college-applications', [CollegeApplicationAdminController::class, 'index'])->name('college-applications.index');
    Route::get('college-applications/{collegeApplication}', [CollegeApplicationAdminController::class, 'show'])->name('college-applications.show');
    Route::put('college-applications/{collegeApplication}/status', [CollegeApplicationAdminController::class, 'updateStatus'])->name('college-applications.status');
    Route::middleware('permission:users.manage')->group(function (): void {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.update-password');
        Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('permission:users.manage')->group(function (): void {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('settings/social-links', [SocialLinksController::class, 'edit'])->name('settings.social-links.edit');
        Route::put('settings/social-links', [SocialLinksController::class, 'update'])->name('settings.social-links.update');
        Route::get('settings/college-website', [CollegeWebsiteController::class, 'edit'])->name('settings.college-website.edit');
        Route::put('settings/college-website', [CollegeWebsiteController::class, 'update'])->name('settings.college-website.update');
        Route::get('security/two-factor', [TwoFactorSettingsController::class, 'edit'])->name('security.two-factor.edit');
        Route::put('security/two-factor', [TwoFactorSettingsController::class, 'update'])->name('security.two-factor.update');
        Route::get('danger-zone', [DangerZoneController::class, 'show'])->name('danger-zone.show');
        Route::post('danger-zone/purge', [DangerZoneController::class, 'purge'])->name('danger-zone.purge');
    });
});
