<?php

namespace App\Twig\Extension;

use App\Config\Config;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Extension;
use Twig_Function;

/**
 * Class Route
 * @package App\Twig\Extension
 */
class Route extends Twig_Extension
{
    /**
     * @var ServerRequestInterface
     */
    private $serverRequest;

    public function __construct(ServerRequestInterface $serverRequest)
    {
        $this->serverRequest = $serverRequest;
    }


    /**
     * @return array|Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('route', [$this, 'route']),
        ];
    }

    /**
     * @param $url
     * @return string
     */
    public function route($url)
    {
        return $this->serverRequest->getUri()->getQuery() . '/' . $url;
    }

}
