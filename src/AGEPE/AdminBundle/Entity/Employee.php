<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 */
class Employee
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $sexe;

    /**
     * @var string
     */
    private $adresse;

    /**
     * @var string
     */
    private $phoneNumbre;

    /**
     * @var string
     */
    private $identificationType;

    /**
     * @var string
     */
    private $identificationNumbre;

    /**
     * @var \DateTime
     */
    private $joinDate;

    /**
     * @var \DateTime
     */
    private $departureDate;

    /**
     * @var string
     */
    private $contractType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Employee
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Employee
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Employee
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Employee
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set phoneNumbre
     *
     * @param string $phoneNumbre
     * @return Employee
     */
    public function setPhoneNumbre($phoneNumbre)
    {
        $this->phoneNumbre = $phoneNumbre;
    
        return $this;
    }

    /**
     * Get phoneNumbre
     *
     * @return string 
     */
    public function getPhoneNumbre()
    {
        return $this->phoneNumbre;
    }

    /**
     * Set identificationType
     *
     * @param string $identificationType
     * @return Employee
     */
    public function setIdentificationType($identificationType)
    {
        $this->identificationType = $identificationType;
    
        return $this;
    }

    /**
     * Get identificationType
     *
     * @return string 
     */
    public function getIdentificationType()
    {
        return $this->identificationType;
    }

    /**
     * Set identificationNumbre
     *
     * @param string $identificationNumbre
     * @return Employee
     */
    public function setIdentificationNumbre($identificationNumbre)
    {
        $this->identificationNumbre = $identificationNumbre;
    
        return $this;
    }

    /**
     * Get identificationNumbre
     *
     * @return string 
     */
    public function getIdentificationNumbre()
    {
        return $this->identificationNumbre;
    }

    /**
     * Set joinDate
     *
     * @param \DateTime $joinDate
     * @return Employee
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;
    
        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime 
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * Set departureDate
     *
     * @param \DateTime $departureDate
     * @return Employee
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;
    
        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime 
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Set contractType
     *
     * @param string $contractType
     * @return Employee
     */
    public function setContractType($contractType)
    {
        $this->contractType = $contractType;
    
        return $this;
    }

    /**
     * Get contractType
     *
     * @return string 
     */
    public function getContractType()
    {
        return $this->contractType;
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
}