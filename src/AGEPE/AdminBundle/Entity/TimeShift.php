<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimeShift
 */
class TimeShift
{
    /**
     * @var string
     */
    private $shiftName;

    /**
     * @var integer
     */
    private $weeklyOffDays;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $timeSlot;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timeSlot = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set shiftName
     *
     * @param string $shiftName
     * @return TimeShift
     */
    public function setShiftName($shiftName)
    {
        $this->shiftName = $shiftName;
    
        return $this;
    }

    /**
     * Get shiftName
     *
     * @return string 
     */
    public function getShiftName()
    {
        return $this->shiftName;
    }

    /**
     * Set weeklyOffDays
     *
     * @param integer $weeklyOffDays
     * @return TimeShift
     */
    public function setWeeklyOffDays($weeklyOffDays)
    {
        $this->weeklyOffDays = $weeklyOffDays;
    
        return $this;
    }

    /**
     * Get weeklyOffDays
     *
     * @return integer 
     */
    public function getWeeklyOffDays()
    {
        return $this->weeklyOffDays;
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
     * Add timeSlot
     *
     * @param \AGEPE\AdminBundle\Entity\TimeSlot $timeSlot
     * @return TimeShift
     */
    public function addTimeSlot(\AGEPE\AdminBundle\Entity\TimeSlot $timeSlot)
    {
        $this->timeSlot[] = $timeSlot;
    
        return $this;
    }

    /**
     * Remove timeSlot
     *
     * @param \AGEPE\AdminBundle\Entity\TimeSlot $timeSlot
     */
    public function removeTimeSlot(\AGEPE\AdminBundle\Entity\TimeSlot $timeSlot)
    {
        $this->timeSlot->removeElement($timeSlot);
    }

    /**
     * Get timeSlot
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimeSlot()
    {
        return $this->timeSlot;
    }



    const SUNDAY = 1; // sunday 00000001
    const MONDAY = 2; // monday 00000010
    const TUESDAY = 4; // tuesday 0000010
    const WEDNESDAY = 8; // wed 00001000
    const THURSDAY =16; // thur 00010000
    const FRIDAY =32; // fri 00100000
    const SATURDAY =64; // sat 01000000

    /*
     *
     * return if $date is an weeklyOff
     *
     * TypeRetourn Boolean
     */
    public function checkWeeklyOff($date)
    {
        $dayMask = [
            0=> self::SUNDAY, // sunday 00000001
            1=> self::MONDAY, // monday 00000010
            2=> self::TUESDAY, // tuesday 0000100
            3=> self::WEDNESDAY, // wed 00001000
            4=> self::THURSDAY, // thur 00010000
            5=> self::FRIDAY, // fri 00100000
            6=> self::SATURDAY, // sat 01000000
        ];
        $a=date('w', $date->getTimestamp()); // 0 (for Sunday) through 6 (for Saturday)

        return ($this->getWeeklyOffDays() & $dayMask [$a]);//if 0 is not weekly off , else is a weeklyof
    }

}