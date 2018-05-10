<?php
/**
 * @author Fady.m <fadymichel.r@gmail.com>
 */

namespace App\Model;

use App\Model\Manager\GoogleApiManager;
use Webbym\DependencyInjection\Container;

/**
 * Class Address
 * @package App\Model
 */
class Address
{

    private $city;
    private $lng;
    private $lat;

    /**
     * @var
     */
    private $type;

    /**
     * @var
     */
    private $address;

    /**
     * @var bool|mixed
     */
    private $details;

    /**
     * Address constructor.
     * @param $address
     * @Todo à refaire
     */
    public function __construct($address)
    {

        $detailsAddress = new GoogleApiManager(Container::getContainer());
        $this->details = $detailsAddress->getDetailsAddress($address);

        $this->_lat = $this->details['results'][0]['geometry']['location']['lat'];
        $this->_lng = $this->details['results'][0]['geometry']['location']['lng'];
        $this->_type = $this->details['results'][0]['types'][0];

        $this->_address = $this->details['results']['0']['formatted_address'];

        $data = [];
        foreach ($this->details['results']['0']['address_components'] as $element) {
            $data[implode(' ', $element['types'])] = $element['long_name'];
        }
        $this->city = $data['locality political'];

    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

}
