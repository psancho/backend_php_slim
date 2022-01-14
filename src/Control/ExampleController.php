<?php declare(strict_types = 1);

namespace Takoma\Template\Api\Control;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Slim\App;
use Slim\Http\ServerRequest;
use Takoma\Lizy\SlimInterface\Control\BaseController;
use Takoma\Lizy\Web\Json;
use Takoma\Lizy\Web\StatusCode;
use Takoma\Template\Api\Model\Example;

class ExampleController extends BaseController
{

    /**
     * GET /examples
     * @param array<string> $args
     */
    public function get(ServerRequest $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!self::acceptJson($request)) {
            return $response->withStatus(StatusCode::HTTP_406_NOT_ACCEPTABLE);
        }

        $json = new Json(['message' => Example::$message]);

        $response->getBody()->write($json->serialize());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /** Définit les endpoints du contrôleur */
    public static function register(App $app): void
    {
        $container = $app->getContainer();
        if (is_null($container)) {
            throw new RuntimeException("app container is null");
        }
        $securityHandler = $container->get('securityHandler');

        $app->group('/examples', function ($app) {
            $app->get('', __CLASS__ . ':get');
        })
        ->add($securityHandler)
        ;
    }
}
