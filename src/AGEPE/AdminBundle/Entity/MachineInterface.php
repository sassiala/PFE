<?php

namespace AGEPE\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MachineInterface
 */
class MachineInterface
{
    /**
     * @var \DateTime
     */
    private $importDate;

    /**
     * @var \DateTime
     */
    private $punchTime;

    /**
     * @var \DateTime
     */
    private $treatedDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AGEPE\AdminBundle\Entity\Employee
     */
    private $employee;


    /**
     * Set importDate
     *
     * @param \DateTime $importDate
     * @return MachineInterface
     */
    public function setImportDate($importDate)
    {
        $this->importDate = $importDate;
    
        return $this;
    }

    /**
     * Get importDate
     *
     * @return \DateTime 
     */
    public function getImportDate()
    {
        return $this->importDate;
    }

    /**
     * Set punchTime
     *
     * @param \DateTime $punchTime
     * @return MachineInterface
     */
    public function setPunchTime($punchTime)
    {
        $this->punchTime = $punchTime;
    
        return $this;
    }

    /**
     * Get punchTime
     *
     * @return \DateTime 
     */
    public function getPunchTime()
    {
        return $this->punchTime;
    }

    /**
     * Set treatedDate
     *
     * @param \DateTime $treatedDate
     * @return MachineInterface
     */
    public function setTreatedDate($treatedDate)
    {
        $this->treatedDate = $treatedDate;
    
        return $this;
    }

    /**
     * Get treatedDate
     *
     * @return \DateTime 
     */
    public function getTreatedDate()
    {
        return $this->treatedDate;
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
     * @return MachineInterface
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