<?php
namespace App\Config;

use App\Repository\SettingRepository;
use App\Model\DataBase;
use App\Model\Setting;

/**
 * Class Config
 * @package App\Config
 */
final class Config
{

    public $parameters = [
        'key_google' => '',
        'view' => 'view/',
        'stripe_secret_key' => '',
        'stripe_public_key' => '',
        'mail_host' => '',
        'mail_port' => 587,
        'mail_username' => '',
        'mail_password' => '',
        'mail_smtp_auth' => true,
        'mail_name' => '',
    ];

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @var Setting
     */
    public $setting = null;


    public function __construct()
    {
        $this->baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        if (is_null($this->setting)) {

            try {

                $this->setting = (new settingRepository((new DataBase())->connect()))->find(1);
            }catch (\Exception $e) {
                
                $this->setting = new Setting();
            }
        }
    }

    /**
     * @param $param
     * @return mixed|null
     */
    public function getParameter($param) {

       return array_key_exists($param,$this->parameters) ? $this->parameters[$param] : null;
    }


}
