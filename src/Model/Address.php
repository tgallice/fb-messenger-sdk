<?php

namespace Tgallice\FBMessenger\Model;

class Address implements \JsonSerializable
{
    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var null|string
     */
    private $secondStreet;

    /**
     * @var string
     */
    private $street;

    /**
     * @param string $street
     * @param string $city
     * @param string $postalCode
     * @param string $state
     * @param string $country
     * @param null|string $secondStreet
     */
    public function __construct($street, $city, $postalCode, $state, $country, $secondStreet = null)
    {
        $this->country = $country;
        $this->state = $state;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->secondStreet = $secondStreet;
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return null|string
     */
    public function getSecondStreet()
    {
        return $this->secondStreet;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'street_1' => $this->street,
            'street_2' => $this->secondStreet,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'country' => $this->country,
            'state' => $this->state,
        ];
    }
}
