<?php

return [
    'name' => 'Cardiothoracic Centre',
    'hospital' => 'Tenwek Hospital',
    'tagline' => 'Excellence in Cardiothoracic Care in East Africa',

    /*
    | Hero background video (landing page). YouTube URL, direct MP4 URL, or HLS manifest (.m3u8).
    | For large files, prefer HLS: host a manifest + segments (small chunks); the site loads hls.js
    | automatically when the URL ends in .m3u8. Example (after ffmpeg):
    |   ffmpeg -i hero.mp4 -c copy -f hls -hls_time 4 -hls_list_size 0 -hls_segment_filename hero_%03d.ts hero.m3u8
    | YouTube embeds autoplay muted and loop. Leave null to use gradient-only background.
    */
    'hero_video' => env('CTC_HERO_VIDEO', 'https://www.youtube.com/watch?v=_kRrI-5-SX0'),

    /*
    | Hero background image (landing page). Used when hero mode is "image".
    */
    'hero_image' => env('CTC_HERO_IMAGE', 'hero.jpg'),

    /*
    | Banner image for inner pages (About, Team, Services, etc.). Used with a gradient overlay.
    */
    'page_banner_image' => env('CTC_PAGE_BANNER_IMAGE', 'https://tenwekhosp.org/wp-content/uploads/2024/03/DJI_0855.jpg'),

    /*
    | Tenwek/Hospital imagery used when no upload exists (About, Purpose, service areas, admin previews).
    | Defaults follow CTC_PAGE_BANNER_IMAGE; set CTC_PLACEHOLDER_* to use different official photos per slot.
    */
    'placeholder_images' => [
        'facility' => env('CTC_PLACEHOLDER_FACILITY', env('CTC_PAGE_BANNER_IMAGE', 'https://tenwekhosp.org/wp-content/uploads/2024/03/DJI_0855.jpg')),
        'team' => env('CTC_PLACEHOLDER_TEAM', env('CTC_PAGE_BANNER_IMAGE', 'https://tenwekhosp.org/wp-content/uploads/2024/03/DJI_0855.jpg')),
        'care' => env('CTC_PLACEHOLDER_CARE', env('CTC_PAGE_BANNER_IMAGE', 'https://tenwekhosp.org/wp-content/uploads/2024/03/DJI_0855.jpg')),
        'story' => env('CTC_PLACEHOLDER_STORY', env('CTC_PAGE_BANNER_IMAGE', 'https://tenwekhosp.org/wp-content/uploads/2024/03/DJI_0855.jpg')),
    ],

    'demo_surgeries' => (int) env('CTC_DEMO_SURGERIES', 5000),

    /*
    | Team / specialists groups (display order on public Specialists page).
    | Keys are stored on team_members.team_group.
    */
    'team_groups' => [
        'cardiothoracic_centre' => 'Cardiothoracic Centre',
        'senior_leadership' => 'Senior Leadership Team',
        'cardiothoracic_surgeons' => 'Cardiothoracic Surgeons',
        'cardiothoracic_fellows' => 'Cardiothoracic Fellows',
        'cardiology' => 'Cardiology Department',
        'endoscopy' => 'Endoscopy Department',
        'paediatric_cardiologist' => 'Paediatric Cardiologist',
        'perfusion' => 'Perfusion',
        'anesthesia' => 'Anesthesia',
        'pharmacy' => 'Pharmacy',
    ],

    'contact' => [
        'address' => 'P.O Box 39, Bomet, Kenya, 036',
        'phone' => '+254 723 000036',
        'email' => 'ctc.info@tenwekhosp.org',
        'emergency' => '+254 723 000036',
    ],

    /*
    | Social links (optional). Use full URLs or leave null.
    */
    'social' => [
        'Facebook' => env('CTC_SOCIAL_FACEBOOK', 'https://www.facebook.com/share/1DVKQQxtz5/'),
        'Instagram' => env('CTC_SOCIAL_INSTAGRAM', 'https://www.instagram.com/agctenwekcardiothoraciccentre'),
        'LinkedIn' => env('CTC_SOCIAL_LINKEDIN', 'https://www.linkedin.com/in/agctenwek-cardiothoracic-centre-6257b1368'),
        'TikTok' => env('CTC_SOCIAL_TIKTOK', 'https://www.tiktok.com/@agc_tenwek'),
        'YouTube' => env('CTC_SOCIAL_YOUTUBE'),
        'X' => env('CTC_SOCIAL_X'),
    ],

    /*
    | College / training partner site (optional). Override in admin Settings or via env.
    | Used on the public Training & Research hub.
    */
    'college_website' => [
        'url' => env('CTC_COLLEGE_WEBSITE_URL'),
        'label' => env('CTC_COLLEGE_WEBSITE_LABEL', 'Tenwek College'),
    ],

    'college_application' => [
        'max_file_mb' => (int) env('CTC_COLLEGE_APPLICATION_MAX_FILE_MB', 5),
    ],

    /*
    | Main menu (navbar): Home, About, Team, Services, Training, Research, Impact, Support.
    */
    'nav' => [
        ['label' => 'Home', 'route' => 'home'],
        [
            'label' => 'About CTC',
            'route' => 'about',
            'dropdown' => 'mega',
            'groups' => [
                [
                    'title' => 'The Centre',
                    'links' => [
                        ['label' => 'Overview', 'route' => 'about', 'description' => 'Who we are, our values, and purpose.'],
                        ['label' => 'History', 'route' => 'history', 'description' => 'Milestones that shaped the CTC.'],
                        ['label' => 'Impact', 'route' => 'impact', 'description' => 'Stories and outcomes across the region.'],
                    ],
                ],
                [
                    'title' => 'People',
                    'links' => [
                        ['label' => 'Our Specialists', 'route' => 'specialists', 'description' => 'Meet our surgeons and care team.'],
                        ['label' => 'Training & Research', 'route' => 'training-research', 'description' => 'Building capacity through learning.'],
                    ],
                ],
                [
                    'title' => 'For patients',
                    'links' => [
                        ['label' => 'Book appointment', 'route' => 'book-appointment', 'description' => 'Request a visit or consultation online.'],
                        ['label' => 'Patient Information', 'route' => 'patient-information', 'description' => 'Referrals, appointments, and what to bring.'],
                        ['label' => 'International Patients', 'route' => 'international-patients', 'description' => 'Guidance for travel and coordination.'],
                        ['label' => 'Contact Us', 'route' => 'contact', 'description' => 'General enquiries and messages.'],
                    ],
                ],
            ],
        ],
        [
            'label' => 'Our Services',
            'route' => 'services',
            'dropdown' => 'mega',
            'mega_max_w' => 920,
            'groups' => [
                [
                    'title' => 'Cardiac Surgery',
                    'links' => [
                        [
                            'label' => 'Explore cardiac surgery',
                            'route' => 'services.category',
                            'route_params' => ['serviceCategory' => 'cardiac-surgery'],
                            'description' => 'Adult and paediatric heart procedures, valves, and bypass.',
                        ],
                    ],
                ],
                [
                    'title' => 'Thoracic Surgery',
                    'links' => [
                        [
                            'label' => 'Explore thoracic surgery',
                            'route' => 'services.category',
                            'route_params' => ['serviceCategory' => 'thoracic-surgery'],
                            'description' => 'Lung, chest wall, and mediastinal surgical care.',
                        ],
                    ],
                ],
                [
                    'title' => 'Diagnostics & pathway',
                    'links' => [
                        [
                            'label' => 'Diagnostics',
                            'route' => 'services.category',
                            'route_params' => ['serviceCategory' => 'diagnostics'],
                            'description' => 'Imaging and testing for accurate diagnosis.',
                        ],
                        ['label' => 'All services', 'route' => 'services'],
                        [
                            'label' => 'Book appointment',
                            'route' => 'book-appointment',
                            'description' => 'Request a visit or consultation online.',
                        ],
                        ['label' => 'Refer a Patient', 'route' => 'patient-information'],
                        ['label' => 'International Patients', 'route' => 'international-patients'],
                    ],
                ],
            ],
        ],
        ['label' => 'Our Specialists', 'route' => 'specialists'],
        [
            'label' => 'Training & Research',
            'route' => 'training-research',
            'dropdown' => 'mega',
            'mega_cols' => 4,
            'mega_max_w' => 980,
            'groups' => [
                [
                    'title' => 'Training',
                    'links' => [
                        ['label' => 'Training overview', 'route' => 'training'],
                        ['label' => 'Fellowship & rotations', 'route' => 'training.fellowship-rotations'],
                    ],
                ],
                [
                    'title' => 'Perfusion School',
                    'links' => [
                        [
                            'label' => 'Apply online',
                            'route' => 'college.apply.landing',
                            'description' => 'Start or resume your application for the current intake.',
                            'cta' => true,
                        ],
                    ],
                ],
                [
                    'title' => 'Research',
                    'links' => [
                        ['label' => 'Research overview', 'route' => 'research'],
                        ['label' => 'Publications', 'route' => 'research.publications'],
                    ],
                ],
                [
                    'title' => 'Explore',
                    'links' => [
                        ['label' => 'Training & Research hub', 'route' => 'training-research'],
                        ['label' => 'News & Media', 'route' => 'news'],
                    ],
                ],
            ],
        ],
        ['label' => 'News & Media', 'route' => 'news'],
        ['label' => 'Contact Us', 'route' => 'contact'],
    ],

    /*
    | Footer links: Patient Info, News, Contact (and any other secondary links).
    */
    'footer' => [
        'description' => env('CTC_FOOTER_DESCRIPTION', 'A specialised cardiothoracic centre of Tenwek Hospital, providing advanced heart and chest care, training, and research in East Africa.'),
        'columns' => [
            [
                'title' => 'The Centre',
                'links' => [
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'About CTC', 'route' => 'about'],
                    ['label' => 'History', 'route' => 'history'],
                    ['label' => 'Our Specialists', 'route' => 'specialists'],
                    ['label' => 'News & Media', 'route' => 'news'],
                    ['label' => 'Gallery', 'route' => 'gallery'],
                ],
            ],
            [
                'title' => 'Services',
                'links' => [
                    ['label' => 'All services', 'route' => 'services'],
                    ['label' => 'Cardiac Surgery', 'url' => '/services/cardiac-surgery'],
                    ['label' => 'Thoracic Surgery', 'url' => '/services/thoracic-surgery'],
                    ['label' => 'Diagnostics', 'url' => '/services/diagnostics'],
                    ['label' => 'Book appointment', 'route' => 'book-appointment'],
                    ['label' => 'Patient Information', 'route' => 'patient-information'],
                ],
            ],
            [
                'title' => 'Patients',
                'links' => [
                    ['label' => 'International Patients', 'route' => 'international-patients'],
                    ['label' => 'Contact Us', 'route' => 'contact'],
                    ['label' => 'Feedback & Complaints', 'route' => 'feedback'],
                    ['label' => 'Privacy Policy', 'route' => 'privacy-policy'],
                    ['label' => 'Terms of Service', 'route' => 'terms-of-service'],
                    ['label' => 'Admin Login', 'url' => '/admin-dashboard/login'],
                ],
            ],
            [
                'title' => 'Training & Research',
                'links' => [
                    ['label' => 'Impact', 'route' => 'impact'],
                    ['label' => 'Support the CTC', 'route' => 'support'],
                    ['label' => 'Training & Research', 'route' => 'training-research'],
                    ['label' => 'Training', 'route' => 'training'],
                    ['label' => 'Fellowship & rotations', 'route' => 'training.fellowship-rotations'],
                    ['label' => 'Perfusion School', 'route' => 'college.apply.landing'],
                    ['label' => 'Apply online', 'route' => 'college.apply.landing'],
                    ['label' => 'Research', 'route' => 'research'],
                    ['label' => 'Publications', 'route' => 'research.publications'],
                ],
            ],
        ],
        'legal_links' => [
            ['label' => 'Privacy Policy', 'url' => '/privacy-policy'],
            ['label' => 'Terms of Service', 'url' => '/terms-of-service'],
            ['label' => 'Feedback & Complaints', 'url' => '/feedback-and-complaints'],
            ['label' => 'Admin Login', 'url' => '/admin-dashboard/login'],
        ],
    ],
];
