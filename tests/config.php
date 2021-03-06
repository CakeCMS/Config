<?php
/**
 * CakeCMS Config
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Config
 * @license   MIT
 * @copyright MIT License http://www.opensource.org/licenses/mit-license.php
 * @link      https://github.com/CakeCMS/Config".
 * @author    Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;

//  Write test application config.
Configure::write('debug', true);
Configure::write('App', [
    'namespace'     => 'Test\App',
    'encoding'      => env('APP_ENCODING', 'UTF-8'),
    'defaultLocale' => env('APP_DEFAULT_LOCALE', 'ru_RU'),
    'base'          => false,
    'dir'           => 'src',
    'cacheDir'      => 'cache',
    'webroot'       => 'webroot',
    'wwwRoot'       => WWW_ROOT,
    'fullBaseUrl'   => 'http://localhost',
    'imageBaseUrl'  => 'img/',
    'cssBaseUrl'    => 'css/',
    'jsBaseUrl'     => 'js/',
    'lessBaseUrl'   => 'less/',
    'paths'         => [
        'plugins' => [
            TEST_APP_DIR . 'plugins' . DS,
            TEST_APP_DIR . 'themes' . DS,
        ],
        'templates' => [
            APP . 'Template' . DS,
        ],
        'locales' => [
            APP . 'Locale' . DS,
        ],
        'elements' => [
            WWW_ROOT . 'elements',
        ]
    ],
]);

Configure::write('EmailTransport', [
    'default' => [
        'className' => 'Mail',
        'host'      => 'localhost',
        'port'      => 25,
        'timeout'   => 30,
        'username'  => 'user',
        'password'  => 'secret',
        'client'    => null,
        'tls'       => null,
    ],
]);

Configure::write('Email', [
    'default' => [
        'transport'     => 'default',
        'from'          => 'you@localhost',
        'charset'       => 'utf-8',
        'headerCharset' => 'utf-8',
    ],
]);

Configure::write('Theme', [
    'site'  => 'Frontend',
    'admin' => 'Backend',
]);

Configure::write('Session', ['defaults' => 'php']);

Cache::config([
    '_cake_core_' => [
        'engine'    => 'File',
        'prefix'    => 'cms_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine'    => 'File',
        'prefix'    => 'cms_model_',
        'serialize' => true
    ]
]);
