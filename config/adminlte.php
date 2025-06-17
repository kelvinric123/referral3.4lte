<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Medical Referral System',
    'title_prefix' => '',
    'title_postfix' => ' | MRS',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>3.4</b>',
    'logo_img' => 'http://qmed.asia/newLanding/img/group-52@1x.png',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Medical Referral System',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'http://qmed.asia/newLanding/img/group-52@1x.png',
            'alt' => 'Medical Referral System Logo',
            'class' => '',
            'width' => null,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'http://qmed.asia/newLanding/img/group-52@1x.png',
            'alt' => 'Medical Referral System Logo',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => null,
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        
        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'blog',
            'url' => 'admin/blog',
            'can' => 'manage-blog',
        ],
        [
            'header' => 'SYSTEM ADMINISTRATION',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'super-admin',
        ],
        [
            'text' => 'Dashboard',
            'url' => 'admin/dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'super-admin',
        ],
        [
            'text' => 'Statistics',
            'url' => 'admin/statistics',
            'icon' => 'fas fa-fw fa-chart-bar',
            'classes' => 'bg-light text-dark',
            'can' => 'super-admin',
        ],
        [
            'text' => 'Admin Management',
            'icon' => 'fas fa-fw fa-cogs',
            'classes' => 'bg-light text-dark',
            'can' => 'super-admin',
            'submenu' => [
                [
                    'text' => 'Hospitals',
                    'url' => 'admin/hospitals',
                    'icon' => 'fas fa-fw fa-hospital',
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Specialties',
                    'url' => 'admin/specialties',
                    'icon' => 'fas fa-fw fa-stethoscope',
                    'active' => ['admin/specialties*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Consultants',
                    'url' => 'admin/consultants',
                    'icon' => 'fas fa-fw fa-user-md',
                    'active' => ['admin/consultants*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Services',
                    'url' => 'admin/services',
                    'icon' => 'fas fa-fw fa-clipboard-list',
                    'active' => ['admin/services*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Clinics',
                    'url' => 'admin/clinics',
                    'icon' => 'fas fa-fw fa-clinic-medical',
                    'active' => ['admin/clinics*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'GPs',
                    'url' => 'admin/gps',
                    'icon' => 'fas fa-fw fa-user-nurse',
                    'active' => ['admin/gps*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        [
            'header' => 'AGENT ADMINISTRATION',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'super-admin',
        ],
        [
            'text' => 'Booking Agent Management',
            'icon' => 'fas fa-fw fa-users-cog',
            'classes' => 'bg-light text-dark',
            'can' => 'super-admin',
            'submenu' => [
                [
                    'text' => 'Companies',
                    'url' => 'admin/companies',
                    'icon' => 'fas fa-fw fa-building',
                    'active' => ['admin/companies*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Booking Agents',
                    'url' => 'admin/booking-agents',
                    'icon' => 'fas fa-fw fa-user-tie',
                    'active' => ['admin/booking-agents*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        [
            'header' => 'REFERRAL MANAGEMENT',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'super-admin',
        ],
        [
            'text' => 'Referral Management',
            'icon' => 'fas fa-fw fa-exchange-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'super-admin',
            'submenu' => [
                [
                    'text' => 'Referrals',
                    'url' => 'admin/referrals',
                    'icon' => 'fas fa-fw fa-file-medical',
                    'active' => ['admin/referrals*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Loyalty Points',
                    'url' => 'admin/loyalty-point-settings',
                    'icon' => 'fas fa-fw fa-star',
                    'active' => ['admin/loyalty-point-settings*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'GP Loyalty Points',
                    'url' => 'admin/gp-loyalty-points',
                    'icon' => 'fas fa-fw fa-user-md',
                    'active' => ['admin/gp-loyalty-points*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Booking Agent Loyalty Points',
                    'url' => 'admin/booking-agent-loyalty-points',
                    'icon' => 'fas fa-fw fa-user-tie',
                    'active' => ['admin/booking-agent-loyalty-points*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        [
            'header' => 'GP AFFILIATE PROGRAM',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'super-admin',
        ],
        [
            'text' => 'GP Affiliate Program',
            'icon' => 'fas fa-fw fa-project-diagram',
            'classes' => 'bg-light text-dark',
            'can' => 'super-admin',
            'submenu' => [
                [
                    'text' => 'Program List',
                    'url' => 'admin/gp-referral-programs',
                    'icon' => 'fas fa-fw fa-list',
                    'active' => ['admin/gp-referral-programs*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Program Participation',
                    'url' => 'admin/gp-referral-program-participation',
                    'icon' => 'fas fa-fw fa-users',
                    'active' => ['admin/gp-referral-program-participation*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        [
            'header' => 'DOCTOR DASHBOARD',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'gp-doctor',
        ],
        [
            'text' => 'GP Dashboard',
            'url' => 'doctor/dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'gp-doctor',
        ],
        [
            'text' => 'Referrals',
            'url' => 'doctor/referrals',
            'icon' => 'fas fa-fw fa-file-medical',
            'can' => 'gp-doctor',
            'active' => ['doctor/referrals*'],
            'classes' => 'bg-light text-primary',
        ],
        [
            'text' => 'GP Loyalty Points',
            'url' => 'doctor/loyalty-points',
            'icon' => 'fas fa-fw fa-star',
            'can' => 'gp-doctor',
            'active' => ['doctor/loyalty-points*'],
            'classes' => 'bg-light text-primary',
        ],
        [
            'header' => 'HOSPITAL PROFILES',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'gp-doctor',
        ],
        [
            'text' => 'Institution Profiles',
            'icon' => 'fas fa-fw fa-hospital-user',
            'can' => 'gp-doctor',
            'classes' => 'bg-light text-dark',
            'submenu' => [
                [
                    'text' => 'Hospital',
                    'url' => 'doctor/profile/hospital',
                    'icon' => 'fas fa-fw fa-hospital',
                    'active' => ['doctor/profile/hospital*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Specialty',
                    'url' => 'doctor/profile/specialty',
                    'icon' => 'fas fa-fw fa-stethoscope',
                    'active' => ['doctor/profile/specialty*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Consultant',
                    'url' => 'doctor/profile/consultant',
                    'icon' => 'fas fa-fw fa-user-md',
                    'active' => ['doctor/profile/consultant*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        [
            'header' => 'GP AFFILIATE PROGRAM',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'gp-doctor',
        ],
        [
            'text' => 'Referral Programs',
            'url' => 'doctor/gp-referral-programs',
            'icon' => 'fas fa-fw fa-clipboard-list',
            'can' => 'gp-doctor',
            'active' => ['doctor/gp-referral-programs*'],
            'classes' => 'bg-light text-primary',
        ],
        
        // Consultant Dashboard
        [
            'header' => 'CONSULTANT DASHBOARD',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'consultant',
        ],
        [
            'text' => 'Consultant Dashboard',
            'url' => 'consultant/dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'consultant',
        ],
        [
            'text' => 'My Referrals',
            'url' => 'consultant/referrals',
            'icon' => 'fas fa-fw fa-file-medical',
            'can' => 'consultant',
            'active' => ['consultant/referrals*'],
            'classes' => 'bg-light text-primary',
        ],
        [
            'text' => 'My Statistics',
            'url' => 'consultant/statistics',
            'icon' => 'fas fa-fw fa-chart-bar',
            'can' => 'consultant',
            'active' => ['consultant/statistics*'],
            'classes' => 'bg-light text-primary',
        ],
        
        // Booking Agent Dashboard
        [
            'header' => 'BOOKING AGENT DASHBOARD',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'booking-agent',
        ],
        [
            'text' => 'Booking Agent Dashboard',
            'url' => 'booking/dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'booking-agent',
        ],
        [
            'text' => 'Referrals',
            'url' => 'booking/referrals',
            'icon' => 'fas fa-fw fa-file-medical',
            'can' => 'booking-agent',
            'active' => ['booking/referrals*'],
            'classes' => 'bg-light text-primary',
        ],
        [
            'text' => 'Booking Agent Loyalty Points',
            'url' => 'booking/loyalty-points',
            'icon' => 'fas fa-fw fa-star',
            'can' => 'booking-agent',
            'active' => ['booking/loyalty-points*'],
            'classes' => 'bg-light text-primary',
        ],
        [
            'header' => 'HOSPITAL PROFILES',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'booking-agent',
        ],
        [
            'text' => 'Institution Profiles',
            'icon' => 'fas fa-fw fa-hospital-user',
            'can' => 'booking-agent',
            'classes' => 'bg-light text-dark',
            'submenu' => [
                [
                    'text' => 'Hospital',
                    'url' => 'booking/profile/hospital',
                    'icon' => 'fas fa-fw fa-hospital',
                    'active' => ['booking/profile/hospital*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Specialty',
                    'url' => 'booking/profile/specialty',
                    'icon' => 'fas fa-fw fa-stethoscope',
                    'active' => ['booking/profile/specialty*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Consultant',
                    'url' => 'booking/profile/consultant',
                    'icon' => 'fas fa-fw fa-user-md',
                    'active' => ['booking/profile/consultant*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        
        // Hospital Admin Dashboard
        [
            'header' => 'HOSPITAL ADMINISTRATION',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'hospital-admin',
        ],
        [
            'text' => 'Hospital Dashboard',
            'url' => 'hospital/dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'hospital-admin',
        ],
        [
            'text' => 'Hospital Statistics',
            'url' => 'hospital/statistics',
            'icon' => 'fas fa-fw fa-chart-bar',
            'classes' => 'bg-light text-dark',
            'can' => 'hospital-admin',
        ],
        [
            'text' => 'Admin Management',
            'icon' => 'fas fa-fw fa-cogs',
            'classes' => 'bg-light text-dark',
            'can' => 'hospital-admin',
            'submenu' => [
                [
                    'text' => 'My Hospital',
                    'url' => 'hospital/hospital',
                    'icon' => 'fas fa-fw fa-hospital',
                    'active' => ['hospital/hospital*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Specialties',
                    'url' => 'hospital/specialties',
                    'icon' => 'fas fa-fw fa-stethoscope',
                    'active' => ['hospital/specialties*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Consultants',
                    'url' => 'hospital/consultants',
                    'icon' => 'fas fa-fw fa-user-md',
                    'active' => ['hospital/consultants*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Services',
                    'url' => 'hospital/services',
                    'icon' => 'fas fa-fw fa-clipboard-list',
                    'active' => ['hospital/services*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Clinics',
                    'url' => 'hospital/clinics',
                    'icon' => 'fas fa-fw fa-clinic-medical',
                    'active' => ['hospital/clinics*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'GPs',
                    'url' => 'hospital/gps',
                    'icon' => 'fas fa-fw fa-user-nurse',
                    'active' => ['hospital/gps*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
        [
            'header' => 'REFERRAL MANAGEMENT',
            'classes' => 'text-bold text-uppercase bg-teal',
            'can' => 'hospital-admin',
        ],
        [
            'text' => 'Referral Management',
            'icon' => 'fas fa-fw fa-exchange-alt',
            'classes' => 'bg-light text-dark',
            'can' => 'hospital-admin',
            'submenu' => [
                [
                    'text' => 'Referrals',
                    'url' => 'hospital/referrals',
                    'icon' => 'fas fa-fw fa-file-medical',
                    'active' => ['hospital/referrals*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Loyalty Points',
                    'url' => 'hospital/loyalty-points',
                    'icon' => 'fas fa-fw fa-star',
                    'active' => ['hospital/loyalty-points*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'GP Loyalty Points',
                    'url' => 'hospital/gp-loyalty-points',
                    'icon' => 'fas fa-fw fa-user-md',
                    'active' => ['hospital/gp-loyalty-points*'],
                    'classes' => 'text-primary',
                ],
                [
                    'text' => 'Booking Agent Loyalty Points',
                    'url' => 'hospital/booking-agent-loyalty-points',
                    'icon' => 'fas fa-fw fa-user-tie',
                    'active' => ['hospital/booking-agent-loyalty-points*'],
                    'classes' => 'text-primary',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
