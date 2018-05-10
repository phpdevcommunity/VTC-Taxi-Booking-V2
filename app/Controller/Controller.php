<?php 

namespace App\Controller;

use GuzzleHttp\Psr7\Response;
use Webbym\DependencyInjection\Container;
use Webbym\Template;

/**
 * Class Controller
 * @package App\Controller
 */
abstract class Controller
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param string $service
     * @return mixed|object
     */
    protected function get(string $service) {

        if (is_null($this->container)) {
            $this->container = Container::getContainer();
        }

        return $this->container->get($service);
    }


    /**
     * @param string $view
     * @param array $parameters
     * @return Response
     */
    protected function render(string $view, array $parameters = [])
    {
        $template = $this->get(Template::class);
        $content = $template->render($view, $parameters);

        return new Response(200, [], $content);
    }
}
