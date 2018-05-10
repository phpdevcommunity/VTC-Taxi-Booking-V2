<?php

namespace App\Controller;


use App\Flash\FlashMessage;
use App\Security\Security;
use App\Session\SessionInterface;
use App\Session\SessionManager;
use App\Twig\Extension\Asset;
use App\Twig\Extension\Flash;
use App\Twig\Extension\Parameters;
use App\Twig\Extension\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Environment;

/**
 * Class AppController
 * @package App\Controller
 */
abstract class AppController extends Controller
{
    use Security;

    /**
     * @var Twig_Environment
     */
    protected $twig;


    /**
     * @var FlashMessage
     */
    private $flash;

    /**
     *
     * @var SessionInterface
     */
    private $session;


    /**
     * @param $view
     * @param array $array
     * @return Response
     * @throws \Exception
     */
    protected function render($view, array $parameters = [])
    {
        if (is_null($this->twig)) {
            $this->buildTwig();
        }

        return new Response(200, [], $this->twig->render($view, $parameters));

    }

    /**
     * @param $route
     * @return Response
     */
    protected function redirectTo($route)
    {
        $response = new Response();
        $response->withHeader('Location', $route);
        return $response;
    }


    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    protected function isAjax(ServerRequestInterface $request)
    {
        $headers = $request->getHeaders();
        return isset($headers['X-Requested-With'])
            && (in_array('XMLHttpRequest', $headers['X-Requested-With']));
    }

    /**
     * @param string $key
     * @param string $message
     * @return FlashMessage
     */
    protected function addFlash(string $key, string $message)
    {

        if (is_null($this->flash)) {
            $this->flash = $this->get(FlashMessage::class);
        }

        return $this->flash->add($key, $message);
    }

    /**
     *
     * @return SessionInterface
     */
    protected function getSession()
    {
        if (is_null($this->session)) {
            $this->session = $this->get(SessionManager::class);
        }

        return $this->session;
    }


    /**
     * @return void
     */
    private function buildTwig() {

        $this->twig = $this->get(Twig_Environment::class);
        $this->twig->addGlobal('session', $this->get(SessionManager::class));
        $this->twig->addExtension($this->get(Parameters::class));
        $this->twig->addExtension($this->get(Asset::class));
        $this->twig->addExtension($this->get(Route::class));
        $this->twig->addExtension($this->get(Flash::class));

    }

}
