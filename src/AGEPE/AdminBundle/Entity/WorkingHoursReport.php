<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkingHoursReport
 */
class WorkingHoursReport
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $dateFrom;

    /**
     * @var \DateTime
     */
    private $dateTo;

    /**
     * @var float
     */
    private $theoricalWorkingHours;

    /**
     * @var float
     */
    private $actualWorkingHours;

    /**
     * @var float
     */
    private $theoricalWorkingDays;

    /**
     * @var float
     */
    private $actualWorkingDays;

    /**
     * @var float
     */
    private $paidLeaveDays;

    /**
     * @var float
     */
    private $paidLeaveHours;

    /**
     * @var float
     */
    private $holidays;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AGEPE\AdminBundle\Entity\Employee
     */
    private $employee;


    /**
     * Set title
     *
     * @param string $title
     * @return WorkingHoursReport
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return WorkingHoursReport
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    
        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     * @return WorkingHoursReport
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    
        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime 
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set theoricalWorkingHours
     *
     * @param float $theoricalWorkingHours
     * @return WorkingHoursReport
     */
    public function setTheoricalWorkingHours($theoricalWorkingHours)
    {
        $this->theoricalWorkingHours = $theoricalWorkingHours;
    
        return $this;
    }

    /**
     * Get theoricalWorkingHours
     *
     * @return float 
     */
    public function getTheoricalWorkingHours()
    {
        return $this->theoricalWorkingHours;
    }

    /**
     * Set actualWorkingHours
     *
     * @param float $actualWorkingHours
     * @return WorkingHoursReport
     */
    public function setActualWorkingHours($actualWorkingHours)
    {
        $this->actualWorkingHours = $actualWorkingHours;
    
        return $this;
    }

    /**
     * Get actualWorkingHours
     *
     * @return float 
     */
    public function getActualWorkingHours()
    {
        return $this->actualWorkingHours;
    }

    /**
     * Set theoricalWorkingDays
     *
     * @param float $theoricalWorkingDays
     * @return WorkingHoursReport
     */
    public function setTheoricalWorkingDays($theoricalWorkingDays)
    {
        $this->theoricalWorkingDays = $theoricalWorkingDays;
    
        return $this;
    }

    /**
     * Get theoricalWorkingDays
     *
     * @return float 
     */
    public function getTheoricalWorkingDays()
    {
        return $this->theoricalWorkingDays;
    }

    /**
     * Set actualWorkingDays
     *
     * @param float $actualWorkingDays
     * @return WorkingHoursReport
     */
    public function setActualWorkingDays($actualWorkingDays)
    {
        $this->actualWorkingDays = $actualWorkingDays;
    
        return $this;
    }

    /**
     * Get actualWorkingDays
     *
     * @return float 
     */
    public function getActualWorkingDays()
    {
        return $this->actualWorkingDays;
    }

    /**
     * Set paidLeaveDays
     *
     * @param float $paidLeaveDays
     * @return WorkingHoursReport
     */
    public function setPaidLeaveDays($paidLeaveDays)
    {
        $this->paidLeaveDays = $paidLeaveDays;
    
        return $this;
    }

    /**
     * Get paidLeaveDays
     *
     * @return float 
     */
    public function getPaidLeaveDays()
    {
        return $this->paidLeaveDays;
    }

    /**
     * Set paidLeaveHours
     *
     * @param float $paidLeaveHours
     * @return WorkingHoursReport
     */
    public function setPaidLeaveHours($paidLeaveHours)
    {
        $this->paidLeaveHours = $paidLeaveHours;
    
        return $this;
    }

    /**
     * Get paidLeaveHours
     *
     * @return float 
     */
    public function getPaidLeaveHours()
    {
        return $this->paidLeaveHours;
    }

    /**
     * Set holidays
     *
     * @param float $holidays
     * @return WorkingHoursReport
     */
    public function setHolidays($holidays)
    {
        $this->holidays = $holidays;
    
        return $this;
    }

    /**
     * Get holidays
     *
     * @return float 
     */
    public function getHolidays()
    {
        return $this->holidays;
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
     * @return WorkingHoursReport
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