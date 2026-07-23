<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $sections = [
            [
                'title' => 'Homepage',
                'items' => [
                    ['label' => 'Hero / Homepage', 'route' => 'admin-dashboard.hero.edit'],
                    ['label' => 'Hero carousel slides', 'route' => 'admin-dashboard.hero.edit', 'hash' => 'carousel-slides'],
                    ['label' => 'Homepage stats', 'route' => 'admin-dashboard.home-stats.index'],
                    ['label' => 'Page header banners', 'route' => 'admin-dashboard.page-banners.index'],
                ],
            ],
            [
                'title' => 'Operations',
                'items' => [
                    ['label' => 'Contact details', 'route' => 'admin-dashboard.contact-settings.edit'],
                    ['label' => 'Legal pages', 'route' => 'admin-dashboard.legal-pages.index'],
                ],
            ],
            [
                'title' => 'Brand',
                'items' => [
                    ['label' => 'Social links', 'route' => 'admin-dashboard.settings.social-links.edit'],
                    ['label' => 'College website (Training & Research)', 'route' => 'admin-dashboard.settings.college-website.edit'],
                ],
            ],
            [
                'title' => 'Security',
                'items' => [
                    ['label' => 'Two-factor authentication', 'route' => 'admin-dashboard.security.two-factor.edit'],
                    ['label' => 'Users & roles', 'route' => 'admin-dashboard.users.index', 'permission' => 'users.manage'],
                    ['label' => 'Danger zone', 'route' => 'admin-dashboard.danger-zone.show', 'permission' => 'users.manage'],
                ],
            ],
        ];

        return view('admin-dashboard.settings.index', compact('sections'));
    }
}

