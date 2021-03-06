<?php
namespace App\Core;

use Slim\App;

/**
 * Class Routes
 * Register Slim routes into provided App object
 *
 * @package App\Core
 */
class Routes
{
    /**
     * @var App Slim App instance
     */
    private $app;

    /**
     * Routes constructor.
     *
     * @param App $app Slim App Instance
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Auto load all Routes
     * Call every protected methods begining with "load" (such as "loadTwig")
     *
     * Add your onwn Routes by creating methods begining with "load"
     */
    public function autoLoadRoutes()
    {
        $modelReflector = new \ReflectionClass(__CLASS__);
        $methods = $modelReflector->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach($methods as $method) {
            if (strrpos($method->name, 'load', -strlen($method->name)) !== false) {
                $this->{$method->name}();
            }
        }
    }

    /**
     * Load front-office routes
     */
    public function loadFrontRoutes()
    {
        $this->app->get('/', 'App\Controller\Web\Front:homeAction')
            ->setName('homepage');
    }

    /**
     * Load back-office routes
     */
    public function loadBackRoutes()
    {
        $this->app->get('/admin', 'App\Controller\Web\Back:dashboardAction')
            ->setName('dashboard');
    }

    /**
     * Load API routes
     */
    public function loadApiRoutes()
    {
        $this->app->get('/api/auth', 'App\Controller\Api\Auth:authAction')
            ->setName('api-auth');

        $this->app->get('/api/user', 'App\Controller\Api\User:getUserAction')
            ->setName('user');
    }
}