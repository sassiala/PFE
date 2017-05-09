<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assignment
 */
class Assignment
{
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
     * @var \AGEPE\AdminBundle\Entity\TimeShift
     */
    private $timeShift;


    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return Assignment
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
     * @return Assignment
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
     * @return Assignment
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

    /**
     * Set timeShift
     *
     * @param \AGEPE\AdminBundle\Entity\TimeShift $timeShift
     * @return Assignment
     */
    public function setTimeShift(\AGEPE\AdminBundle\Entity\TimeShift $timeShift = null)
    {
        $this->timeShift = $timeShift;
    
        return $this;
    }

    /**
     * Get timeShift
     *
     * @return \AGEPE\AdminBundle\Entity\TimeShift 
     */
    public function getTimeShift()
    {
        return $this->timeShift;
    }
}