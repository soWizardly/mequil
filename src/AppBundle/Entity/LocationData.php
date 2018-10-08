<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationData
 *
 * @ORM\Table(name="location_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationDataRepository")
 */
class LocationData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="location_id", type="integer")
     */
    private $locationId;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float")
     */
    private $temperature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set locationId
     *
     * @param integer $locationId
     *
     * @return LocationData
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;

        return $this;
    }

    /**
     * Get locationId
     *
     * @return int
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * Set temp
     *
     * @param float $temperature
     *
     * @return LocationData
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temp
     *
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return LocationData
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getLocation()
    {
        return $this->location;
    }
}

