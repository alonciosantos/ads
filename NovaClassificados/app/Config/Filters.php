<?php

namespace Config;

use App\Entities\Advert;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter; // ADICIONADO PARA USAR NOSSO FILTRO AUTH
use App\Filters\SuperadminFilter;
use App\Filters\HasSubscriptionFilter;
use App\Filters\PaymentFilter;
use App\Filters\AdvertFilter;

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

        //  'auth'     => \Fluent\Auth\Filters\AuthenticationFilter::class, lança exception

        'auth' => AuthFilter::class, //nossa filtro de auth

        'can'      => \Fluent\Auth\Filters\AuthorizeFilter::class,
        'confirm'  => [
           // \Fluent\Auth\Filters\AuthenticationFilter::class, //lança exception
           AuthFilter::class,
            \Fluent\Auth\Filters\ConfirmPasswordFilter::class,
        ],
        'guest'    => \Fluent\Auth\Filters\RedirectAuthenticatedFilter::class,
        'throttle' => \Fluent\Auth\Filters\ThrottleFilter::class,
        'verified' => \Fluent\Auth\Filters\EmailVerifiedFilter::class,

        'superadmin' => [
            AuthFilter::class, // verifica se está logado
            SuperadminFilter::class, // verifica se é superUsuario
        ],

        'auth_verified' => [
            AuthFilter::class, // verifica se está logado
            'verified' => \Fluent\Auth\Filters\EmailVerifiedFilter::class, // verifica se o email foi verificado

        ],
        //Filtro que nao permite que o anunciante entre em meus anuncios, sem que o plano esteja pago
        'subscription' => [ // objeto a ser chamado na raiz da rota adverts 
            AuthFilter::class, // verifica se está logado
            HasSubscriptionFilter::class, // verifica se o anunciante tem um plano.
            PaymentFilter::class, // verifica se a assinatura ja foi paga.

        ],
        'adverts' =>[
            AuthFilter::class, // verificamos se está logado
            AdvertFilter::class,

        ],
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf' => ['except' => ['api/*']],
            //'csrf' => ['except' => ['jwt/*']],
            
            // 'invalidchars',
        ],
        'after' => [
            
           'toolbar' => ['except' => ['api/*']],
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
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
    public $filters = [];
}
