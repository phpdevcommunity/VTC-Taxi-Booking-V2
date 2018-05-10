<?php

namespace App\Model;


use Fady\Entity\Entity;

/**
 * Class Reservation
 * @package App\Model
 */
class Reservation extends Entity
{

    const PAYMENT_CASH = 1;
    const PAYMENT_CARD = 2;


    /**
     * @var string
     * @Mapped
     */
    protected $depart;
    /**
     * @var string
     * @Mapped
     */
    protected $arrival;

    /**
     * @var int
     * @Mapped
     */
    protected $distance;

    /**
     * @var string
     * @Mapped
     */
    protected $howLong;

    /**
     * @var \DateTime
     * @Mapped
     */
    protected $dateTransfer;
    /**
     * @var \DateTime
     * @Mapped
     */
    protected $timeTransfer;

    /**
     * @var string
     * @Mapped
     */
    protected $reference;

    /**
     * @var int
     * @Mapped
     */
    protected $passengers;
    /**
     * @var string
     * @Mapped
     */
    protected $vol;

    /*
     * @var string
     * @Mapped
     */
    protected $note;

    /**
     * @var float
     * @Mapped
     */
    protected $price;

    /**
     * @var int
     * @Mapped
     */
    protected $methodPayment;

    /**
     * @var string
     * @Mapped
     */
    protected $lastName;
    /**
     * @var string
     * @Mapped
     */
    protected $firstName;

    /**
     * @var string
     * @Mapped
     */
    protected $mail;

    /**
     * @var string
     * @Mapped
     */
    protected $phone;
    /**
     * @var \DateTime
     * @Mapped
     */
    protected $dateReservation;

    /**
     * @var int
     * @Mapped
     */
    protected $carId;

    /**
     * No mapped -----------------------------------
     */

    /**
     * @var Car
     */
    protected $car;
    
    /**
     * @var Address
     */
    protected $detailsAddressFrom;

    /**
     * @var Address
     */
    protected $detailsAddressTo;


    public function __construct(array $data = null)
    {
        $this->hydrate($data);

        if ($this->getId() === null || empty($this->getId())) {

            $this->reference = 'N' . mt_rand(10000, 90000);
            $this->dateReservation = new \DateTime();
            $this->methodPayment = self::PAYMENT_CASH;

        }

    }


    /**
     * @return string
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @param string $depart
     */
    public function setDepart(string $depart)
    {
        $this->depart = $depart;
        return $this; 
    }

    /**
     * @return string
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param string $arrival
     */
    public function setArrival(string $arrival)
    {
        $this->arrival = $arrival;
        return $this;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     */
    public function setDistance(int $distance)
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return string
     */
    public function getHowLong()
    {
        return $this->howLong;
    }

    /**
     * @param string $howLong
     */
    public function setHowLong(string $howLong)
    {
        $this->howLong = $howLong;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTransfer()
    {
        return $this->dateTransfer;
    }

    /**
     * @param \DateTime $dateTransfer
     */
    public function setDateTransfer(\DateTime $dateTransfer)
    {
        $this->dateTransfer = $dateTransfer;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeTransfer()
    {
        return $this->timeTransfer;
    }

    /**
     * @param \DateTime $timeTransfer
     */
    public function setTimeTransfer(\DateTime $timeTransfer)
    {
        $this->timeTransfer = $timeTransfer;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference(string $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return int
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @param int $passengers
     */
    public function setPassengers(int $passengers)
    {
        $this->passengers = $passengers;
        return $this;
    }

    /**
     * @return string
     */
    public function getVol()
    {
        return $this->vol;
    }

    /**
     * @param string $vol
     */
    public function setVol(string $vol)
    {
        $this->vol = $vol;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getMethodPayment()
    {
        return $this->methodPayment;
    }

    /**
     * @param int $methodPayment
     */
    public function setMethodPayment(int $methodPayment)
    {
        $this->methodPayment = $methodPayment;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * @param \DateTime $dateReservation
     */
    public function setDateReservation(\DateTime $dateReservation)
    {
        $this->dateReservation = $dateReservation;
        return $this;
    }

    /**
     * @return int
     */
    public function getCarId()
    {
        return $this->carId;
    }

    /**
     * @param int $carId
     */
    public function setCarId(int $carId)
    {
        $this->carId = $carId;
        return $this;
    }

    /**
     * @return Car
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param Car $car
     * @return $this
     */
    public function setCar(Car $car = null)
    {
        $this->car = $car;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetailsAddressFrom()
    {
        return $this->detailsAddressFrom;
    }

    /**
     * @param mixed $detailsAddressFrom
     */
    public function setDetailsAddressFrom(Address $detailsAddressFrom)
    {
        $this->detailsAddressFrom = $detailsAddressFrom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetailsAddressTo()
    {
        return $this->detailsAddressTo;
    }

    /**
     * @param mixed $detailsAddressTo
     */
    public function setDetailsAddressTo(Address $detailsAddressTo)
    {
        $this->detailsAddressTo = $detailsAddressTo;
        return $this;
    }



}
