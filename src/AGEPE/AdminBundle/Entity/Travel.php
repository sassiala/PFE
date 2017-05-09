<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Travel
 */
class Travel
{
    /**
     * @var string
     */
    private $Title;

    /**
     * @var \DateTime
     */
    private $fromDate;

    /**
     * @var \DateTime
     */
    private $toDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AGEPE\AdminBundle\Entity\Employee
     */
    private $employee;


    /**
     * Set Title
     *
     * @param string $title
     * @return Travel
     */
    public function setTitle($title)
    {
        $this->Title = $title;
    
        return $this;
    }

    /**
     * Get Title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return Travel
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    
        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime 
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set toDate
     *
     * @param \DateTime $toDate
     * @return Travel
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    
        return $this;
    }

    /**
     * Get toDate
     *
     * @return \DateTime 
     */
    public function getToDate()
    {
        return $this->toDate;
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

    /**
     * Set employee
     *
     * @param \AGEPE\AdminBundle\Entity\Employee $employee
     * @return Travel
     */
    public function setEmployee(\AGEPE\AdminBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return \AGEPE\AdminBundle\Entity\Employee 
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}