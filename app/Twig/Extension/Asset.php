<?php

namespace App\Twig\Extension;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Function;
use Twig_Extension;


/**
 * Class Asset
 * @package App\Twig\Extension
 */
class Asset extends Twig_Extension
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
            new Twig_Function('asset', [$this, 'asset']),
        ];
    }

    /**
     * @param $path
     * @return string
     */
    public function asset($path)
    {
        return $this->serverRequest->getUri()->getQuery() . '/' . $path;
    }

}
