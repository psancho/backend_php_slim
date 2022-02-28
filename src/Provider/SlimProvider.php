<?php declare(strict_types=1);

namespace Takoma\Template\Api\Provider;

use RuntimeException;
use Slim\App;
use Slim\Factory\AppFactory;
use Takoma\Lizy\Conf;
use Takoma\Lizy\Lizy;
use Takoma\Lizy\SlimInterface\Control\VersionController;
use Takoma\Lizy\SlimInterface\Middleware\CacheHandler;
use Takoma\Lizy\SlimInterface\Middleware\CorsHandler;
use Takoma\Lizy\SlimInterface\Middleware\ErrorHandler;
use Takoma\Lizy\SlimInterface\Middleware\SecurityHandler;
use Takoma\Lizy\SlimInterface\Model\Container;
use Takoma\Template\Api\Control\ExampleController;

class SlimProvider
{
    /** initialisation et lancement de l'app Slim */
    public static function init(): void
    {
        // obligatoire pour les WS
        Lizy::logFatalError();

        // désactivation du contrôle d'accès sur machine de dev avec l'option restApi.securityDisabled
        $overrideSecurity = (bool) Conf::get()->getOption('restApi', 'securityDisabled');
        $disableCache = Conf::get()->getOption('restApi', 'cacheDisabled', false);

        $container = new Container;
        $container->set('securityHandler', new SecurityHandler(true, $overrideSecurity));
        AppFactory::setContainer($container);

        $app = AppFactory::create();
        $basepath = Conf::get()->getOption('slim', 'basepath');
        if (is_null($basepath)) {
            throw new RuntimeException("slim.basepath not set in config.ini.", 1);
        }
        $app->setBasePath($basepath);

        $app->addRoutingMiddleware();
        // le dernier middleware ajouté est invoqué en 1er
        $app->add(new CorsHandler);
        $app->add(new CacheHandler($disableCache));

        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setDefaultErrorHandler(new ErrorHandler);

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
