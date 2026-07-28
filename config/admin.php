<?php

return [
    'menu' => [
        ['label' => 'Dashboard Home', 'route' => 'admin-dashboard.index', 'icon' => 'dashboard', 'group' => 'Overview'],

        // Homepage
        ['label' => 'Site images', 'route' => 'admin-dashboard.site-images.index', 'icon' => 'photo', 'group' => 'Homepage'],
        ['label' => 'Page header banners', 'route' => 'admin-dashboard.page-banners.index', 'icon' => 'photo', 'group' => 'Homepage'],
        ['label' => 'Hero / Homepage', 'route' => 'admin-dashboard.hero.edit', 'icon' => 'photo', 'group' => 'Homepage'],
        ['label' => 'Hero Carousel Slides', 'route' => 'admin-dashboard.hero.edit', 'hash' => 'carousel-slides', 'icon' => 'photo', 'group' => 'Homepage'],
        ['label' => 'Homepage Stats', 'route' => 'admin-dashboard.home-stats.index', 'icon' => 'chart', 'group' => 'Homepage'],

        // About / Story
        ['label' => 'Who We Are (About Intro)', 'route' => 'admin-dashboard.about-intro.edit', 'icon' => 'information-circle', 'group' => 'About'],
        ['label' => 'Purpose (Mission & Vision)', 'route' => 'admin-dashboard.about-purpose.edit', 'icon' => 'information-circle', 'group' => 'About'],
        ['label' => 'Core Values (Guides)', 'route' => 'admin-dashboard.core-values.index', 'icon' => 'heart', 'group' => 'About'],
        ['label' => 'About Section', 'route' => 'admin-dashboard.about.index', 'icon' => 'information-circle', 'group' => 'About'],
        ['label' => 'History Milestones', 'route' => 'admin-dashboard.history-milestones.index', 'icon' => 'clock', 'group' => 'About'],
        ['label' => 'History Gallery', 'route' => 'admin-dashboard.history-gallery.index', 'icon' => 'photo', 'group' => 'About'],

        // Departments
        ['label' => 'Department pages', 'route' => 'admin-dashboard.department-pages.index', 'icon' => 'document-text', 'permission' => 'services.manage', 'group' => 'Departments'],

        // Content
        ['label' => 'Services', 'route' => 'admin-dashboard.services.index', 'icon' => 'briefcase', 'permission' => 'services.manage', 'group' => 'Content'],
        ['label' => 'Service area pages', 'route' => 'admin-dashboard.service-category-pages.index', 'icon' => 'document-text', 'permission' => 'services.manage', 'group' => 'Content'],
        ['label' => 'Patient Information', 'route' => 'admin-dashboard.patient-info.index', 'icon' => 'document-text', 'group' => 'Content'],
        ['label' => 'Training Programs', 'route' => 'admin-dashboard.training.index', 'icon' => 'academic-cap', 'group' => 'Content'],
        ['label' => 'Research / Publications', 'route' => 'admin-dashboard.research.index', 'icon' => 'book-open', 'group' => 'Content'],
        ['label' => 'Impact Stories', 'route' => 'admin-dashboard.impact.index', 'icon' => 'heart', 'group' => 'Content'],
        ['label' => 'Impact Testimonials', 'route' => 'admin-dashboard.impact-testimonials.index', 'icon' => 'heart', 'group' => 'Content'],
        ['label' => 'Support / Donations', 'route' => 'admin-dashboard.donations.index', 'icon' => 'currency-dollar', 'group' => 'Content'],
        ['label' => 'News / Articles', 'route' => 'admin-dashboard.news.index', 'icon' => 'newspaper', 'permission' => 'news.manage', 'group' => 'Content'],
        ['label' => 'Events', 'route' => 'admin-dashboard.events.index', 'icon' => 'calendar', 'permission' => 'news.manage', 'group' => 'Content'],
        ['label' => 'Gallery', 'route' => 'admin-dashboard.gallery.index', 'icon' => 'photo', 'group' => 'Content'],

        // Operations
        ['label' => 'Bookings / Appointments', 'route' => 'admin-dashboard.bookings.index', 'icon' => 'calendar', 'group' => 'Operations'],
        ['label' => 'Contact & Enquiries', 'route' => 'admin-dashboard.enquiries.index', 'icon' => 'mail', 'group' => 'Operations'],
        ['label' => 'College Applications', 'route' => 'admin-dashboard.college-applications.index', 'icon' => 'document-text', 'group' => 'Operations'],
        ['label' => 'Contact Details', 'route' => 'admin-dashboard.contact-settings.edit', 'icon' => 'phone', 'group' => 'Operations'],
        ['label' => 'Legal pages', 'route' => 'admin-dashboard.legal-pages.index', 'icon' => 'document-text', 'group' => 'Operations'],

        // People & Access
        ['label' => 'Team / Staff', 'route' => 'admin-dashboard.team-members.index', 'icon' => 'users', 'permission' => 'team.manage', 'group' => 'People'],
        ['label' => 'Specialists', 'route' => 'admin-dashboard.team-members.index', 'icon' => 'user-group', 'group' => 'People'],
        ['label' => 'Users & Roles', 'route' => 'admin-dashboard.users.index', 'icon' => 'shield-check', 'permission' => 'users.manage', 'group' => 'Administration'],
        ['label' => 'Two-factor authentication', 'route' => 'admin-dashboard.security.two-factor.edit', 'icon' => 'shield-check', 'permission' => 'users.manage', 'group' => 'Administration'],
    ],

    // Essential quick links for the admin header dropdown
    'header_links' => [
        ['label' => 'Dashboard', 'route' => 'admin-dashboard.index', 'icon' => 'dashboard'],
        ['label' => 'My profile', 'route' => 'admin-dashboard.profile.edit', 'icon' => 'users'],
        ['label' => 'Settings', 'route' => 'admin-dashboard.settings.index', 'icon' => 'document-text', 'permission' => 'users.manage'],
        ['label' => 'Site images', 'route' => 'admin-dashboard.site-images.index', 'icon' => 'photo'],
        ['label' => 'Edit Home Hero', 'route' => 'admin-dashboard.hero.edit', 'icon' => 'photo'],
        ['label' => 'Homepage Stats', 'route' => 'admin-dashboard.home-stats.index', 'icon' => 'chart'],
        ['label' => 'About: Who we are', 'route' => 'admin-dashboard.about-intro.edit', 'icon' => 'information-circle'],
        ['label' => 'Bookings / Appointments', 'route' => 'admin-dashboard.bookings.index', 'icon' => 'calendar'],
        ['label' => 'Contact & Enquiries', 'route' => 'admin-dashboard.enquiries.index', 'icon' => 'mail'],
        ['label' => 'College Applications', 'route' => 'admin-dashboard.college-applications.index', 'icon' => 'document-text'],
        ['label' => 'Users & Roles', 'route' => 'admin-dashboard.users.index', 'icon' => 'shield-check', 'permission' => 'users.manage'],
        ['label' => 'Danger zone', 'route' => 'admin-dashboard.danger-zone.show', 'icon' => 'shield-check', 'permission' => 'users.manage', 'danger' => true],
    ],

    /*
     * Admin page tips: help admins understand what public page/section they are editing.
     * Patterns use Laravel Str::is wildcards against the current route name.
     */
    'tips' => [
        ['pattern' => 'admin-dashboard.index', 'text' => 'Tip: This is the admin overview (no public page directly).'],

        ['pattern' => 'admin-dashboard.site-images.*', 'text' => 'Tip: Edit shared photos by public page (Home, About, Support, Services). Each card shows the page + section. Header banners are listed lower on this screen.', 'public' => '/support'],
        ['pattern' => 'admin-dashboard.page-banners.*', 'text' => 'Tip: Custom header images for inner pages; default comes from Site Images → Default page header banner when not set.'],
        ['pattern' => 'admin-dashboard.hero.*', 'text' => 'Tip: Editing the Home page hero (video / carousel).', 'public' => '/'],
        ['pattern' => 'admin-dashboard.home-stats.*', 'text' => 'Tip: Editing the Home page statistics section.', 'public' => '/#home-stats'],

        ['pattern' => 'admin-dashboard.about-intro.*', 'text' => 'Tip: Editing the “Who we are” intro on the About page.', 'public' => '/about'],
        ['pattern' => 'admin-dashboard.about.*', 'text' => 'Tip: Editing the About page content.', 'public' => '/about'],
        ['pattern' => 'admin-dashboard.history-milestones.*', 'text' => 'Tip: Editing the History page milestones.', 'public' => '/history'],
        ['pattern' => 'admin-dashboard.history-gallery.*', 'text' => 'Tip: Editing History page gallery images and captions.', 'public' => '/history'],

        ['pattern' => 'admin-dashboard.team-members.*', 'text' => 'Tip: Editing the Specialists / Team pages.', 'public' => '/specialists'],
        ['pattern' => 'admin-dashboard.services.*', 'text' => 'Tip: Editing the Services page.', 'public' => '/services'],
        ['pattern' => 'admin-dashboard.department-pages.*', 'text' => 'Tip: Editing department landing pages (Cardiology, Cardiothoracic Surgery, Endoscopy).', 'public' => '/departments/endoscopy'],
        ['pattern' => 'admin-dashboard.service-category-pages.*', 'text' => 'Tip: Editing long-form category pages (e.g. /services/cardiac-surgery).', 'public' => '/services/cardiac-surgery'],
        ['pattern' => 'admin-dashboard.patient-info.*', 'text' => 'Tip: Editing the Patient Information page.', 'public' => '/patient-information'],
        ['pattern' => 'admin-dashboard.training.*', 'text' => 'Tip: Editing the Training pages.', 'public' => '/training'],
        ['pattern' => 'admin-dashboard.settings.college-website.*', 'text' => 'Tip: College link on the public Training & Research hub.', 'public' => '/training-research'],
        ['pattern' => 'admin-dashboard.research.*', 'text' => 'Tip: Editing the Research pages.', 'public' => '/research'],
        ['pattern' => 'admin-dashboard.impact.*', 'text' => 'Tip: Editing the Impact page stories (including featured success story).', 'public' => '/impact'],
        ['pattern' => 'admin-dashboard.impact-testimonials.*', 'text' => 'Tip: Editing testimonials shown on the Impact page carousel.', 'public' => '/impact'],
        ['pattern' => 'admin-dashboard.donations.*', 'text' => 'Tip: Editing the Support / Donations page.', 'public' => '/support'],
        ['pattern' => 'admin-dashboard.news.*', 'text' => 'Tip: Editing the News page articles.', 'public' => '/news'],
        ['pattern' => 'admin-dashboard.events.*', 'text' => 'Tip: Editing Events content shown on the Events page.', 'public' => '/events'],
        ['pattern' => 'admin-dashboard.gallery.*', 'text' => 'Tip: Editing the public Gallery page images.', 'public' => '/gallery'],

        ['pattern' => 'admin-dashboard.enquiries.*', 'text' => 'Tip: Managing messages submitted via the Contact page.', 'public' => '/contact'],
        ['pattern' => 'admin-dashboard.college-applications.*', 'text' => 'Tip: Review applications for the School of Health Sciences programme.'],
        ['pattern' => 'admin-dashboard.contact-settings.*', 'text' => 'Tip: Editing public contact details shown on the Contact page.', 'public' => '/contact'],
        ['pattern' => 'admin-dashboard.legal-pages.*', 'text' => 'Tip: Editing Privacy Policy and Terms of Service.', 'public' => '/privacy-policy'],
        ['pattern' => 'admin-dashboard.bookings.*', 'text' => 'Tip: Managing appointment requests from the public Book appointment page.', 'public' => '/book-appointment'],

        ['pattern' => 'admin-dashboard.users.*', 'text' => 'Tip: Managing admin users and roles (not public).'],
        ['pattern' => 'admin-dashboard.security.two-factor.*', 'text' => 'Tip: Control whether admin sign-in requires a second step (not public).'],
        ['pattern' => 'admin-dashboard.danger-zone.*', 'text' => 'Tip: Permanently purge selected test/staging data. Users, team, and services are never deleted here.'],
    ],
];
