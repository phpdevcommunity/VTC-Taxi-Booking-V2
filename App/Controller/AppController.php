<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 06/11/17
 * Time: 20:20
 */

namespace App\Controller;

use App\Twig\Extension\Asset;
use App\Twig\Extension\Message;
use App\Twig\Extension\Parameters;
use App\Twig\Extension\Route as Route_Extension;
use Twig_Loader_Filesystem;
use Twig_Environment;
use MySettings;

class AppController
{
    /**
     * @var Twig_Environment
     */
    protected $twig;


    public function __construct()
    {

        $loader = new Twig_Loader_Filesystem('view');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => false,
        ));
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new Parameters());
        $this->twig->addExtension(new Asset());
        $this->twig->addExtension(new Route_Extension());
        $this->twig->addExtension(new Message());
    }

    /**
     * @param $view
     * @param array $array
     */
    protected function render($view, Array $array) {
        echo $this->twig->render($view, $array);
    }

    /**
     * @param $route
     * @param int $status
     * @return mixed
     */
    protected function redirectTo($route, $status = 302)
    {
        $route = $route == 'last_route' ? (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '') : MySettings::$_url.''.$route;

        header('Location: '.$route, true, $status);
        return false;
    }

    /**
     * logout
     */
    public function logOut() {

        if (isset($_SESSION['id_em'])) {

            unset($_SESSION['id_em']);
        }
        $this->redirectTo('home');

    }

    /**
     * @return bool
     */
    protected function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param $page
     * @return bool
     */
    public function other($page)
    {

        $page = str_replace("/", "", $page);

        if (is_file('view/' . $page . '.html.twig')) {

            $this->render('view' . $page .'.html.twig', []);
        }
        else {
            return false;
        }

    }

}
