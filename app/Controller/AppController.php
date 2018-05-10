<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 06/11/17
 * Time: 20:20
 */

namespace App\Controller;


use App\Flash\FlashMessage;
use App\Security\Security;
use App\Session\SessionInterface;
use App\Session\SessionManager;
use App\Twig\Extension\Asset;
use App\Twig\Extension\Flash;
use App\Twig\Extension\Parameters;
use App\Twig\Extension\Route as Route_Extension;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

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
     * AppController constructor.
     */
    public function __construct()
    {


        $this->twig = $this->get(Twig_Environment::class);
        $this->twig->enableDebug();
        $this->twig->addGlobal('session', $this->get(SessionManager::class));
        $this->twig->addExtension($this->get(Parameters::class));
        $this->twig->addExtension($this->get(Asset::class));
        $this->twig->addExtension($this->get(Route_Extension::class));
        $this->twig->addExtension($this->get(Flash::class));
    }

    /**
     * @param $view
     * @param array $array
     * @return Response
     * @throws \Exception
     */
    protected function render($view, array $parameters = [])
    {

        return new Response(200, [], $this->twig->render($view, $parameters));

    }

    /**
     * @param $route
     * @return Response
     */
    protected function redirectTo($route)
    {
        return (new Response())->withHeader('Location', $route);
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


}
