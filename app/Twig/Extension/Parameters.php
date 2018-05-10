<?php


namespace App\Twig\Extension;

use App\Config\Config;
use App\Model\Setting;
use App\Repository\SettingRepository;
use Twig_Extension;
use Twig_Function;
use Psr\Container\ContainerInterface;
use Webbym\DependencyInjection\Container;

/**
 * Class Parameters
 * @package App\Twig\Extension
 */
class Parameters extends Twig_Extension
{

    /**
     *
     * @var array
     */
    private $parameters = [];

    /**
     * @var SettingRepository
     */
    private $settingRepository;


    /**
     * @var Setting $setting
     */
    private $setting;

    public function __construct(ContainerInterface $container, SettingRepository $settingRepository)
    {
        $this->parameters = $container->getParameters();
        $this->settingRepository = $settingRepository;
    }

    /**
     * @return array|Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('param', [$this, 'param']),
            new Twig_Function('setting', [$this, 'setting']),
        ];
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function param(string $key)
    {
        if (array_key_exists($key, $this->parameters)) {

            return $this->parameters[$key];
        }
        return null;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function setting(string $property)
    {
        if (is_null($this->setting)) {
            $this->setting = $this->settingRepository->find(1);
        }

        $method = 'get'.ucfirst($property);
        if (method_exists($this->setting, $method)) {
            return $this->setting->$method();
        }

        return null;
    }
}
