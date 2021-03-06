<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 */
class Config
{
    /**
     * @var string
     */
    private $configName;

    /**
     * @var string
     */
    private $configCode;

    /**
     * @var string
     */
    private $configValue;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set configName
     *
     * @param string $configName
     * @return Config
     */
    public function setConfigName($configName)
    {
        $this->configName = $configName;
    
        return $this;
    }

    /**
     * Get configName
     *
     * @return string 
     */
    public function getConfigName()
    {
        return $this->configName;
    }

    /**
     * Set configCode
     *
     * @param string $configCode
     * @return Config
     */
    public function setConfigCode($configCode)
    {
        $this->configCode = $configCode;
    
        return $this;
    }

    /**
     * Get configCode
     *
     * @return string 
     */
    public function getConfigCode()
    {
        return $this->configCode;
    }

    /**
     * Set configValue
     *
     * @param string $configValue
     * @return Config
     */
    public function setConfigValue($configValue)
    {
        $this->configValue = $configValue;
    
        return $this;
    }

    /**
     * Get configValue
     *
     * @return string 
     */
    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    public function addValueAsMinutesFrom(\DateTime $date){

        $minutes_as_seconds = (int)$this->getConfigValue() * 60;
        $timestamp = $date->getTimestamp() + $minutes_as_seconds;

        $newDate  = date_create();
        date_timestamp_set($newDate, $timestamp);
        return $newDate;
    }

    public function deductValueAsMinutesFrom(\DateTime $date){

        $minutes_as_seconds = (int)$this->getConfigValue() * 60;
        $timestamp = $date->getTimestamp() - $minutes_as_seconds;

        $newDate  = date_create();
        date_timestamp_set($newDate, $timestamp);
        return $newDate;
    }
    /**
     * @var \DateTime
     */
    private $createIn;


    /**
     * Set createIn
     *
     * @param \DateTime $createIn
     * @return Config
     */
    public function setCreateIn($createIn)
    {
        $this->createIn = $createIn;
    
        return $this;
    }

    /**
     * Get createIn
     *
     * @return \DateTime 
     */
    public function getCreateIn()
    {
        return $this->createIn;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return Config
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}