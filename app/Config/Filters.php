<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin'   => \App\Filters\FilterAdmin::class,
        'filterSeller'  => \App\Filters\filterSeller::class,
        'login'         => \Myth\Auth\Filters\LoginFilter::class,
        'role'          => \Myth\Auth\Filters\RoleFilter::class,
        'permission'    => \Myth\Auth\Filters\PermissionFilter::class,
        // 'apipicking'     => \App\Filters\ApiPicking::class,
        // 'apikaryawan'     => \App\Filters\ApiKaryawan::class,
        // 'apiinbound'     => \App\Filters\ApiInbound::class,
        // 'apimanifest'     => \App\Filters\ApiManifest::class,
        // 'apiorder'     => \App\Filters\ApiOrder::class,
        // 'apipacking'     => \App\Filters\ApiPacking::class,
        'authenticate' => \App\Filters\Authenticate::class, // tambahkan ini
        'redirectIfAuthenticated' => \App\Filters\RedirectIfAuthenticated::class, // tambahkan ini
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'apipicking',
            // 'honeypot',
            'login' => [
                'except'    => ['ApiKaryawan', 'ApiInbound', 'ApiManifest', 'ApiOrder', 'ApiPacking', 'ApiPicking', 'assets', 'assets/*', 'ApiKaryawan/*', 'ApiInbound/*', 'ApiManifest/*', 'ApiOrder/*', 'ApiPacking/*', 'ApiPicking/*']
            ],
            // 'apikaryawan',
            // 'csrf',
            // 'filterAdmin' => [
            //     'except'    => ['login/*', 'login', '/']
            // ],
            // 'filterSeller' => [
            //     'except'    => ['login/*', 'login', '/']
            // ]
        ],
        'after' => [

            // 'honeypot',
            // 'filterAdmin' => [
            //     'except'    => []
            // ],
            // 'filterSeller' => [
            //     'except'    => ['main/*', 'Stock/*', 'Invoice/*']
            // ],
            // 'toolbar',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'login' => ['before' => ['account/*']],
    ];
}