<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimeSlot
 */
class TimeSlot
{
    /**
     * @var \DateTime
     */
    private $slotFrom;

    /**
     * @var \DateTime
     */
    private $slotTo;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $timeShift;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timeShift = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set slotFrom
     *
     * @param \DateTime $slotFrom
     * @return TimeSlot
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
     * @return TimeSlot
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add timeShift
     *
     * @param \AGEPE\AdminBundle\Entity\TimeShift $timeShift
     * @return TimeSlot
     */
    public function addTimeShift(\AGEPE\AdminBundle\Entity\TimeShift $timeShift)
    {
        $this->timeShift[] = $timeShift;
    
        return $this;
    }

    /**
     * Remove timeShift
     *
     * @param \AGEPE\AdminBundle\Entity\TimeShift $timeShift
     */
    public function removeTimeShift(\AGEPE\AdminBundle\Entity\TimeShift $timeShift)
    {
        $this->timeShift->removeElement($timeShift);
    }

    /**
     * Get timeShift
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimeShift()
    {
        return $this->timeShift;
    }
    /**
     * @var \DateTime
     */
    private $minFrom;

    /**
     * @var \DateTime
     */
    private $maxFrom;

    /**
     * @var \DateTime
     */
    private $minTo;

    /**
     * @var \DateTime
     */
    private $maxTo;


    /**
     * Set minFrom
     *
     * @param \DateTime $minFrom
     * @return TimeSlot
     */
    public function setMinFrom($minFrom)
    {
        $this->minFrom = $minFrom;
    
        return $this;
    }

    /**
     * Get minFrom
     *
     * @return \DateTime 
     */
    public function getMinFrom()
    {
        return $this->minFrom;
    }

    /**
     * Set maxFrom
     *
     * @param \DateTime $maxFrom
     * @return TimeSlot
     */
    public function setMaxFrom($maxFrom)
    {
        $this->maxFrom = $maxFrom;
    
        return $this;
    }

    /**
     * Get maxFrom
     *
     * @return \DateTime 
     */
    public function getMaxFrom()
    {
        return $this->maxFrom;
    }

    /**
     * Set minTo
     *
     * @param \DateTime $minTo
     * @return TimeSlot
     */
    public function setMinTo($minTo)
    {
        $this->minTo = $minTo;
    
        return $this;
    }

    /**
     * Get minTo
     *
     * @return \DateTime 
     */
    public function getMinTo()
    {
        return $this->minTo;
    }

    /**
     * Set maxTo
     *
     * @param \DateTime $maxTo
     * @return TimeSlot
     */
    public function setMaxTo($maxTo)
    {
        $this->maxTo = $maxTo;
    
        return $this;
    }

    /**
     * Get maxTo
     *
     * @return \DateTime 
     */
    public function getMaxTo()
    {
        return $this->maxTo;
    }
}