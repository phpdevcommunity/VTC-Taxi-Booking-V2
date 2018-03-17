<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 06/11/17
 * Time: 20:20
 */

namespace App\Controller;

use App\Config\Config;
use App\Flash\FlashMessage;
use App\Security\Security;
use App\Twig\Extension\Asset;
use App\Twig\Extension\Parameters;
use App\Twig\Extension\Route as Route_Extension;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Loader_Filesystem;
use Twig_Environment;

/**
 * Class AppController
 * @package App\Controller
 */
abstract class AppController
{
    use Security;

    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var FlashMessage
     */
    private $flash;


    public function __construct()
    {
        $this->config = new Config();
        $this->flash = new FlashMessage();

        $loader = new Twig_Loader_Filesystem('view');
        $this->twig = new Twig_Environment($loader, [
            'cache' => false,
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('flash', $this->flash);
        $this->twig->addExtension(new Parameters());
        $this->twig->addExtension(new Asset());
        $this->twig->addExtension(new Route_Extension());
    }

    /**
     * @param $view
     * @param array $array
     * @return Response
     */
    protected function render($view, Array $array)
    {

        try {

            return new Response(200, [],$this->twig->render($view, $array));
        } catch (\Exception $e) {

            return new Response($e->getMessage());
        }
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
     * logout
     */
    public function logOut()
    {

        if (isset($_SESSION['id_em'])) {

            unset($_SESSION['id_em']);
        }
        return $this->redirectTo('home');

    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    protected function isAjax(ServerRequestInterface $request)
    {
        $headers = $request->getHeaders();
        return isset($headers['X-Requested-With'])
            && (in_array('XMLHttpRequest',$headers['X-Requested-With']));
    }


    /**
     * @return Config
     */
    protected function getConfig() {

        return $this->config;
    }

    /**
     * @param string $key
     * @param string $message
     * @return FlashMessage
     */
    protected function addFlash(string $key,string $message) {

        return $this->flash->add($key,$message);
    }

}
