<?php declare(strict_types = 1);

namespace Takoma\Template\Api\Control;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Takoma\Lizy\SlimInterface\Control\BaseController;
use Takoma\Lizy\Web\Json;
use Takoma\Lizy\Web\StatusCode;
use Takoma\Template\Api\Model\Example;

/**
 * Description
 *
 * @category Takoma\Template\Api
 * @package  Api
 */
class ExampleController extends BaseController
{

    /**
     * GET /examples
     *
     * @param Request  $request  requête PSR7
     * @param Response $response réponse PSR7
     * @param array    $args     arguments (npp, business)
     *
     * @return Response
     */
    public function get(Request $request, Response $response, array $args)
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

    /**
     * Définit les endpoints du contrôleur
     *
     * @param App $app Application Slim
     */
    public static function register(App $app)
    {
        $container = $app->getContainer();
        $securityHandler = $container->get('securityHandler');

        $app->group('/examples', function () use ($app) {
            $app->get('', __CLASS__ . ':get');
        })
        ->add($securityHandler);
    }
}
