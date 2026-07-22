<?php

return [
    /*
    | Keys map to SiteSetting `page_banner.{key}` (stored path on the public disk).
    | When empty, the default from config('ctc.page_banner_image') is shown.
    */
    'pages' => [
        ['key' => 'about', 'label' => 'About CTC', 'route' => 'about'],
        ['key' => 'history', 'label' => 'History', 'route' => 'history'],
        ['key' => 'specialists', 'label' => 'Our Specialists', 'route' => 'specialists'],
        ['key' => 'specialist_show', 'label' => 'Specialist profile (all)', 'route' => 'specialists'],
        ['key' => 'services', 'label' => 'Services: overview', 'route' => 'services'],
        ['key' => 'services_cardiac', 'label' => 'Services: Cardiac surgery', 'route' => 'services.category', 'route_params' => ['serviceCategory' => 'cardiac-surgery']],
        ['key' => 'services_thoracic', 'label' => 'Services: Thoracic surgery', 'route' => 'services.category', 'route_params' => ['serviceCategory' => 'thoracic-surgery']],
        ['key' => 'services_diagnostics', 'label' => 'Services: Diagnostics', 'route' => 'services.category', 'route_params' => ['serviceCategory' => 'diagnostics']],
        ['key' => 'service_show', 'label' => 'Service detail (all)', 'route' => 'services'],
        ['key' => 'patient_information', 'label' => 'Patient Information', 'route' => 'patient-information'],
        ['key' => 'international_patients', 'label' => 'International Patients', 'route' => 'international-patients'],
        ['key' => 'training', 'label' => 'Training', 'route' => 'training'],
        ['key' => 'training_fellowship_rotations', 'label' => 'Cardiothoracic Surgery Fellowship', 'route' => 'training.fellowship-rotations'],
        ['key' => 'training_perfusion', 'label' => 'Cardiovascular Perfusion Training', 'route' => 'training.perfusion'],
        ['key' => 'training_research', 'label' => 'Training & Research hub', 'route' => 'training-research'],
        ['key' => 'research', 'label' => 'Research', 'route' => 'research'],
        ['key' => 'research_publications', 'label' => 'Research publications', 'route' => 'research.publications'],
        ['key' => 'impact', 'label' => 'Impact', 'route' => 'impact'],
        ['key' => 'support', 'label' => 'Support the CTC', 'route' => 'support'],
        ['key' => 'gallery', 'label' => 'Gallery', 'route' => 'gallery'],
        ['key' => 'contact', 'label' => 'Contact', 'route' => 'contact'],
        ['key' => 'book_appointment', 'label' => 'Book appointment', 'route' => 'book-appointment'],
        ['key' => 'privacy_policy', 'label' => 'Privacy Policy', 'route' => 'privacy-policy'],
        ['key' => 'terms_of_service', 'label' => 'Terms of Service', 'route' => 'terms-of-service'],
        ['key' => 'feedback', 'label' => 'Feedback & Complaints', 'route' => 'feedback'],
    ],
];
