<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyWorkJournal
 */
class DailyWorkJournal
{
    /**
     * @var \DateTime
     */
    private $asDate;

    /**
     * @var \DateTime
     */
    private $slotFrom;

    /**
     * @var \DateTime
     */
    private $slotTo;

    /**
     * @var \DateTime
     */
    private $computedFrom;

    /**
     * @var \DateTime
     */
    private $computedTo;

    /**
     * @var boolean
     */
    private $dayOff;

    /**
     * @var boolean
     */
    private $weeklyDayOff;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AGEPE\AdminBundle\Entity\PaidLeave
     */
    private $paidLeave;

    /**
     * @var \AGEPE\AdminBundle\Entity\MachineInterface
     */
    private $machineInterfaceTo;

    /**
     * @var \AGEPE\AdminBundle\Entity\MachineInterface
     */
    private $machineInterfaceFrom;

    /**
     * @var \AGEPE\AdminBundle\Entity\Employee
     */
    private $employee;

    /**
     * @var \AGEPE\AdminBundle\Entity\Holiday
     */
    private $holiday;


    /**
     * Set asDate
     *
     * @param \DateTime $asDate
     * @return DailyWorkJournal
     */
    public function setAsDate($asDate)
    {
        $this->asDate = $asDate;
    
        return $this;
    }

    /**
     * Get asDate
     *
     * @return \DateTime 
     */
    public function getAsDate()
    {
        return $this->asDate;
    }

    /**
     * Set slotFrom
     *
     * @param \DateTime $slotFrom
     * @return DailyWorkJournal
     */
    public function setSlotFrom($slotFrom)
    {
        $this->slotFrom = $slotFrom;
    
        return $this;
    }

    /**
     * Get slotFrom
     *
     * @return \DateTime 
     */
    public function getSlotFrom()
    {
        return $this->slotFrom;
    }

    /**
     * Set slotTo
     *
     * @param \DateTime $slotTo
     * @return DailyWorkJournal
     */
    public function setSlotTo($slotTo)
    {
        $this->slotTo = $slotTo;
    
        return $this;
    }

    /**
     * Get slotTo
     *
     * @return \DateTime 
     */
    public function getSlotTo()
    {
        return $this->slotTo;
    }

    /**
     * Set computedFrom
     *
     * @param \DateTime $computedFrom
     * @return DailyWorkJournal
     */
    public function setComputedFrom($computedFrom)
    {
        $this->computedFrom = $computedFrom;
    
        return $this;
    }

    /**
     * Get computedFrom
     *
     * @return \DateTime 
     */
    public function getComputedFrom()
    {
        return $this->computedFrom;
    }

    /**
     * Set computedTo
     *
     * @param \DateTime $computedTo
     * @return DailyWorkJournal
     */
    public function setComputedTo($computedTo)
    {
        $this->computedTo = $computedTo;
    
        return $this;
    }

    /**
     * Get computedTo
     *
     * @return \DateTime 
     */
    public function getComputedTo()
    {
        return $this->computedTo;
    }

    /**
     * Set dayOff
     *
     * @param boolean $dayOff
     * @return DailyWorkJournal
     */
    public function setDayOff($dayOff)
    {
        $this->dayOff = $dayOff;
    
        return $this;
    }

    /**
     * Get dayOff
     *
     * @return boolean 
     */
    public function getDayOff()
    {
        return $this->dayOff;
    }

    /**
     * Set weeklyDayOff
     *
     * @param boolean $weeklyDayOff
     * @return DailyWorkJournal
     */
    public function setWeeklyDayOff($weeklyDayOff)
    {
        $this->weeklyDayOff = $weeklyDayOff;
    
        return $this;
    }

    /**
     * Get weeklyDayOff
     *
     * @return boolean 
     */
    public function getWeeklyDayOff()
    {
        return $this->weeklyDayOff;
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
     * Set paidLeave
     *
     * @param \AGEPE\AdminBundle\Entity\PaidLeave $paidLeave
     * @return DailyWorkJournal
     */
    public function setPaidLeave(\AGEPE\AdminBundle\Entity\PaidLeave $paidLeave = null)
    {
        $this->paidLeave = $paidLeave;
    
        return $this;
    }

    /**
     * Get paidLeave
     *
     * @return \AGEPE\AdminBundle\Entity\PaidLeave 
     */
    public function getPaidLeave()
    {
        return $this->paidLeave;
    }

    /**
     * Set machineInterfaceTo
     *
     * @param \AGEPE\AdminBundle\Entity\MachineInterface $machineInterfaceTo
     * @return DailyWorkJournal
     */
    public function setMachineInterfaceTo(\AGEPE\AdminBundle\Entity\MachineInterface $machineInterfaceTo = null)
    {
        $this->machineInterfaceTo = $machineInterfaceTo;
    
        return $this;
    }

    /**
     * Get machineInterfaceTo
     *
     * @return \AGEPE\AdminBundle\Entity\MachineInterface 
     */
    public function getMachineInterfaceTo()
    {
        return $this->machineInterfaceTo;
    }

    /**
     * Set machineInterfaceFrom
     *
     * @param \AGEPE\AdminBundle\Entity\MachineInterface $machineInterfaceFrom
     * @return DailyWorkJournal
     */
    public function setMachineInterfaceFrom(\AGEPE\AdminBundle\Entity\MachineInterface $machineInterfaceFrom = null)
    {
        $this->machineInterfaceFrom = $machineInterfaceFrom;
    
        return $this;
    }

    /**
     * Get machineInterfaceFrom
     *
     * @return \AGEPE\AdminBundle\Entity\MachineInterface 
     */
    public function getMachineInterfaceFrom()
    {
        return $this->machineInterfaceFrom;
    }

    /**
     * Set employee
     *
     * @param \AGEPE\AdminBundle\Entity\Employee $employee
     * @return DailyWorkJournal
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
     * Set holiday
     *
     * @param \AGEPE\AdminBundle\Entity\Holiday $holiday
     * @return DailyWorkJournal
     */
    public function setHoliday(\AGEPE\AdminBundle\Entity\Holiday $holiday = null)
    {
        $this->holiday = $holiday;
    
        return $this;
    }

    /**
     * Get holiday
     *
     * @return \AGEPE\AdminBundle\Entity\Holiday 
     */
    public function getHoliday()
    {
        return $this->holiday;
    }
    /**
     * @var \AGEPE\AdminBundle\Entity\Travel
     */
    private $travel;


    /**
     * Set travel
     *
     * @param \AGEPE\AdminBundle\Entity\Travel $travel
     * @return DailyWorkJournal
     */
    public function setTravel(\AGEPE\AdminBundle\Entity\Travel $travel = null)
    {
        $this->travel = $travel;
    
        return $this;
    }

    /**
     * Get travel
     *
     * @return \AGEPE\AdminBundle\Entity\Travel 
     */
    public function getTravel()
    {
        return $this->travel;
    }
}