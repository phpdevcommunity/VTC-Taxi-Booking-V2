<?php

namespace App\Model;

use Fady\Entity\Entity;

/**
 * Class Setting
 * @package App\Model
 */
class Setting extends Entity
{

    /**
     * @var string
     * @Mapped
     */
    protected $society;
    /**
     * @var string
     * @Mapped
     */
    protected $numberSociety;
    /**
     * @var string
     * @Mapped
     */
    protected $phone;
    /**
     * @var string
     * @Mapped
     */
    protected $link;
    /**
     * @var string
     * @Mapped
     */
    protected $email;
    /**
     * @var string
     * @Mapped
     */
    protected $address;

    /**
     * @var string
     * @Mapped
     */
    protected $background;

    /**
     * @return mixed
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * @param mixed $society
     */
    public function setSociety($society)
    {
        $this->society = $society;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberSociety()
    {
        return $this->numberSociety;
    }

    /**
     * @param mixed $numberSociety
     */
    public function setNumberSociety($numberSociety)
    {
        $this->numberSociety = $numberSociety;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param string|null $background
     * @return Setting
     */
    public function setBackground(string $background = null)
    {
        $this->background = $background;
        return $this;
    }

}
