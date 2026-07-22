<?php

namespace App\Providers;

use App\Models\AboutSection;
use App\Models\ImpactStory;
use App\Models\ImpactTestimonial;
use App\Models\NewsArticle;
use App\Models\PatientInfoBlock;
use App\Models\ResearchPublication;
use App\Support\Seo\Seo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('news', fn (string $value) => NewsArticle::findOrFail($value));
        Route::bind('about_section', fn (string $value) => AboutSection::findOrFail($value));
        Route::bind('patient_info_block', fn (string $value) => PatientInfoBlock::findOrFail($value));
        Route::bind('patient_info', fn (string $value) => PatientInfoBlock::findOrFail($value));
        Route::bind('research_publication', fn (string $value) => ResearchPublication::findOrFail($value));
        Route::bind('impact_story', fn (string $value) => ImpactStory::findOrFail($value));
        Route::bind('impact_testimonial', fn (string $value) => ImpactTestimonial::findOrFail($value));

        View::composer(['layouts.app'], function ($view): void {
            $request = request();
            if (! $request) {
                return;
            }
            $data = $view->getData();
            $seo = Seo::build($request, [
                'title' => $data['pageTitle'] ?? null,
                'description' => $data['metaDescription'] ?? null,
                'image' => $data['seoImage'] ?? null,
                'breadcrumbs' => $data['breadcrumbs'] ?? null,
                'schema' => $data['seoSchema'] ?? null,
                'pageTitle' => $data['pageTitle'] ?? null,
            ]);
            $view->with('seo', $seo);
        });
    }
}
