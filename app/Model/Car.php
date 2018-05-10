<?php

namespace App\Model;


use Fady\Entity\Entity;

/**
 * Class Car
 * @package App\Model
 */
class Car extends Entity
{

    /**
     * @var string
     * @Mapped
     */
    protected $type;
    /**
     * @var float
     * @Mapped
     */
    protected $kmPrice;
    /**
     * @var float
     * @Mapped
     */
    protected $minutePrice;
    /**
     * @var float
     * @Mapped
     */
    protected $minimumPrice;
    /**
     * @var int
     * @Mapped
     */
    protected $increase;
    /**
     * @var int
     * @Mapped
     */
    protected $places;
    /**
     * @var int
     * @Mapped
     */
    protected $bags;
    /**
     * @var bool
     * @Mapped
     */
    protected $active = true;

    /**
     * @var string
     * @Mapped
     */
    protected $image;


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKmPrice()
    {
        return $this->kmPrice;
    }

    /**
     * @param mixed $kmPrice
     */
    public function setKmPrice($kmPrice)
    {
        $this->kmPrice = $kmPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinutePrice()
    {
        return $this->minutePrice;
    }

    /**
     * @param mixed $minutePrice
     */
    public function setMinutePrice($minutePrice)
    {
        $this->minutePrice = $minutePrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinimumPrice()
    {
        return $this->minimumPrice;
    }

    /**
     * @param mixed $minimumPrice
     */
    public function setMinimumPrice($minimumPrice)
    {
        $this->minimumPrice = $minimumPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIncrease()
    {
        return $this->increase;
    }

    /**
     * @param mixed $increase
     */
    public function setIncrease($increase)
    {
        $this->increase = $increase;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param mixed $places
     */
    public function setPlaces(int $places)
    {
        $this->places = (int)$places;
        return $this;
    }

    /**
     * @return int
     */
    public function getBags()
    {
        return $this->bags;
    }

    /**
     * @param int $bags
     */
    public function setBags(int $bags)
    {
        $this->bags = $bags;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;

        return $this;
    }


}
