<?php declare(strict_types = 1);

namespace Takoma\Template\Api\Provider;

use Slim\App;
use Slim\Container;
use Takoma\Lizy\Conf;
use Takoma\Lizy\Lizy;
use Takoma\Lizy\SlimInterface\Control\VersionController;
use Takoma\Lizy\SlimInterface\Middleware\CacheHandler;
use Takoma\Lizy\SlimInterface\Middleware\CorsHandler;
use Takoma\Lizy\SlimInterface\Middleware\ErrorHandler;
use Takoma\Lizy\SlimInterface\Middleware\PhpErrorHandler;
use Takoma\Lizy\SlimInterface\Middleware\SecurityHandler;
use Takoma\Template\Api\Control\ExampleController;

class RestApiProvider
{

    /** initialisation et lancement de l'app Slim */
    public static function init(): void
    {
        // obligatoire pour les WS
        Lizy::logFatalError();

        // désactivation du contrôle d'accès sur machine de dev avec l'option restApi.securityDisabled
        $overrideSecurity = (bool) Conf::get()->getOption('restApi', 'securityDisabled');
        $disableCache = Conf::get()->getOption('restApi', 'cacheDisabled', false);
        $cipherKey = Conf::get()->getOption('oauth', 'cipherKey');

        $container = new Container([
            'errorHandler' => function ($c) {
                return new ErrorHandler;
            },
            'phpErrorHandler' => function ($c) {
                return new PhpErrorHandler;
            },
            'securityHandler' => function ($c) use ($overrideSecurity) {
                return new SecurityHandler(true, $overrideSecurity);
            },
                // toute entrée ici peut être récupérée par $container->get($key)
        ]);

        $app = new App($container);

        // le dernier middleware ajouté est invoqué en 1er
        $app->add(new CorsHandler);
        $app->add(new CacheHandler($disableCache));

        static::registerControllers($app);

        $app->run();
    }

    /** définition des routes */
    protected static function registerControllers(App $app): void
    {
        VersionController::register($app);
        ExampleController::register($app);
    }
}
