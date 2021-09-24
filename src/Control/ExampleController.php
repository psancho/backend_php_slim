<?php declare(strict_types = 1);

namespace Takoma\Template\Api\Control;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Takoma\Lizy\SlimInterface\Control\BaseController;
use Takoma\Lizy\Web\Json;
use Takoma\Lizy\Web\StatusCode;
use Takoma\Template\Api\Model\Example;

class ExampleController extends BaseController
{

    /** GET /examples */
    public function get(Request $request, Response $response, array $args): Response
    {
        if (!$this->isJsonAccepted()) {
            return $response->withStatus(StatusCode::HTTP_406_NOT_ACCEPTABLE);
        }

        $json = new Json(['message' => Example::$message]);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->write($json->serialize())
        ;
    }

    /** Définit les endpoints du contrôleur */
    public static function register(App $app): void
    {
        $container = $app->getContainer();
        $securityHandler = $container->get('securityHandler');

        $app->group('/examples', function () use ($app) {
            $app->get('', __CLASS__ . ':get');
        })
        ->add($securityHandler);
    }
}
