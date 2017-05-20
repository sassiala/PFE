<?php

namespace AGEPE\AdminBundle\Command;

/**
 * Created by PhpStorm.
 * User: ALA
 * Date: 28-04-2017
 * Time: 17:44
 */

use AGEPE\AdminBundle\Entity\Assignment;
use AGEPE\AdminBundle\Entity\Config;
use AGEPE\AdminBundle\Entity\DailyWorkJournal;
use AGEPE\AdminBundle\Entity\Employee;
use AGEPE\AdminBundle\Entity\Holiday;
use AGEPE\AdminBundle\Entity\InterfaceMachine;
use AGEPE\AdminBundle\Entity\MachineInterface;
use AGEPE\AdminBundle\Entity\PaidLeave;
use AGEPE\AdminBundle\Entity\TimeShift;
use AGEPE\AdminBundle\Entity\TimeSlot;
use Doctrine\Entity;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AGEPE\AdminBundle\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Query\AST\Functions\DateDiffFunction;
use DateInterval;

class dailyWorkCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('AGEPE:dwj')
            ->setDefinition(array(
                new InputArgument('date', InputArgument::OPTIONAL, 'Processing date'),
            ))
            ->setDescription('Géneration de la table DailyWorkJournal')
        ;


    }//end of method config

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // get prcoessing date from arguments, set it to today if not provided
        // ------------------- ----------------------------------------------------
        $date = $input->getArgument('date');
        if ($date==''){
            $date = new \DateTime( date('Y-m-d') ) ;
           var_dump($date->getTimestamp()->d);
        }
        else{
            $date =  \DateTime::createFromFormat( 'Y-m-d', $date ) ;
            // TODO : validate the date string
            //disc: if date is exist in work_journal table or not
            // if not correct, display an error and end ths script
        }

        $output->writeln(sprintf("\nProcessing day \"%s\"...\n", $date->format('d/m/Y')));

        // check if the day provided is already processed
        // if so exit

        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        //find all Processed Employee in this Date
        //for checked if this date is Processed or not
        $date_processed=$qb->select('d')
            ->from('AGEPEAdminBundle:DailyWorkJournal','d')
            ->where('d.asDate = :date')
            ->setParameter('date',$date->format('Y-m-d'))
            ->getQuery()
            ->getResult();

        //if this Date is Processed
        //then stop Processing
        //else continue
        if ($date_processed){
            $output->writeln(sprintf('Already processed. Ending..'));
            return;
        }
        else {
            $output->writeln(sprintf("%s Not processed then processed it now ... \n",$date->format('d/m/Y')));
        }

        //--------
        //--else continue
        //----------------------------------------

        //-----------
        //--check if date is holiday or not
        //----------------------------------------

        $holidays=$this->CheckHoliday($date);
        if ($holidays){
            $output->writeln(sprintf("\"%s\" is an Holiday ..\n",$date->format('d/m/Y')));
        }
        else {
            $output->writeln(sprintf("\"%s\" is not an Holiday ..\n",$date->format('d/m/Y')));
        }
        //--------
        //--Find the list of Employee Already active
        //--whene his departure_date is not null or strictly lower of $date
        //------------------------------------------
        $activeEmployees=$this->ActiveEmployee($date);
        if ($activeEmployees){
            $output->writeln(sprintf("found Active Employee in \"%s\" ..\n",$date->format('d/m/Y')));
        }


        $NULL_TO_PUNCH_CONFIG= $this->getContainer()
            ->get('doctrine')
            ->getRepository('AGEPEAdminBundle:Config')
            ->findOneByConfigCode('NULL_TO_PUNCH');

        $NULL_FROM_PUNCH_CONFIG= $this->getContainer()->get('doctrine')
            ->getRepository('AGEPEAdminBundle:Config')
            ->findOneByConfigCode('NULL_FROM_PUNCH');

        $RETARD_FROM=$this->getContainer()->get('doctrine')
            ->getRepository('AGEPEAdminBundle:Config')
            ->findOneByConfigCode('RETARD_FROM');

        $RETARD_TO=$this->getContainer()->get('doctrine')
            ->getRepository('AGEPEAdminBundle:Config')
            ->findOneByConfigCode('RETARD_TO');

        $RETARD_FROM_VALUE=$this->getContainer()->get('doctrine')
            ->getRepository('AGEPEAdminBundle:Config')
            ->findOneByConfigCode('RETARD_FROM_VALUE');

        $RETARD_TO_VALUE=$this->getContainer()->get('doctrine')
            ->getRepository('AGEPEAdminBundle:Config')
            ->findOneByConfigCode('RETARD_TO_VALUE');

        //-----
        //--loop over all employee active
        //---------------------------------

        if($activeEmployees)
        {
            foreach ($activeEmployees as $employee)
            {

                //----
                //--check if $employee is in Paid_leave date
                //-------------------------------------------
                $paidLeave=$this->CheckPaidLeave($date,$employee);
                if($paidLeave)
                {
                    $output->writeln(sprintf("\"%s\" have an Paidleave in \"%s\" ..\n"
                        ,$employee->getFirstName()
                        ,$date->format('d/m/Y')));
                }
                else
                {
                    $output->writeln(sprintf("\"%s\" not have an Paidleave in \"%s\" ..\n"
                        ,$employee->getFirstName()
                        ,$date->format('d/m/Y')));
                }



                //----
                //--check Employee in travel or not
                //-------------------------------------------

                $travel = $this->CheckTravel($employee, $date);
                if($travel)
                {
                    $output->writeln(sprintf("\"%s\" is in Travel from \"%s\" to \"%s\" ..\n"
                        ,$employee->getFirstName()
                        ,$travel->getFromDate()->format('d/m/Y'),$travel->getToDate()->format('d/m/Y')));
                }
                else
                {
                    $output->writeln(sprintf("\"%s\" is not in Travel now \"%s\" ..\n"
                        ,$employee->getFirstName()
                        ,$date->format('Y-m-d')));
                }
                //----
                //--find Shift of employee in $date
                //-------------------------------------------

                $shift = $this->getEmployeeCurrentShift($employee, $date);

                if($shift) {

                    //----
                    //--check if $date is an WeeklyOff ///Type bool
                    //-------------------------------------------

                    $weeklyOffDay = $shift->checkWeeklyOff($date);

                    if ($weeklyOffDay != 0) {
                        $output->writeln(sprintf("\"%s\" his Weekly Off Day ..\n"
                            , $date->format('Y-m-d')));
                    }

                    //----
                    //--find Slots of employee in $date
                    //-------------------------------------------

                    $slots = $shift->getTimeSlot();

                    if ($slots) {
                        foreach ($slots as $slot) {

                            //----
                            //--Create Object DailyWorkJournal
                            //--For each activeEmployees
                            //-----------------------------------------

                            $journal = new DailyWorkJournal();

                            //----
                            //--fill the table with known field
                            //--and set the not known field as NULL
                            //--------------------------------------

                            $journal->setAsDate($date);
                            $journal->setSlotFrom(null);
                            $journal->setSlotTo(null);
                            $journal->setComputedFrom(null);
                            $journal->setComputedTo(null);
                            $journal->setWeeklyDayOff(false);
                            $journal->setDayOff(false);
                            $journal->setTravel(null);
                            $journal->setPaidLeave(null);
                            $journal->setMachineInterfaceFrom(null);
                            $journal->setMachineInterfaceTo(null);
                            $journal->setEmployee($employee);
                            $journal->setHoliday(null);


                            if($paidLeave)
                                $journal->setPaidLeave($paidLeave);

                            if($holidays)
                                $journal->setHoliday($holidays);

                            if($travel)
                                $journal->setTravel($travel);

                            if ($weeklyOffDay != 0)
                                $journal->setWeeklyDayOff(true);

                            $output->writeln(sprintf(" Slots from \"%s\" to \"%s\"..."
                                , $slot->getSlotFrom()->format('G:i')
                                , $slot->getSlotTo()->format('G:i')));

                            $journal->setSlotFrom($slot->getSlotFrom());
                            $journal->setSlotTo($slot->getSlotTo());

                            //----
                            //--determine PunchFrom & PunchTo
                            //----------------------------------
                            $punchFrom = $this->getPunchFrom($slot, $employee, $date);
                            $punchTo = $this->getPunchTo($slot, $employee, $date);


                            $journal->setMachineInterfaceFrom($punchFrom);
                            $journal->setMachineInterfaceTo($punchTo);

                            //----
                            //--Determine ComputedFrom & ComputedTo
                            //---------------------------------------

                            if(!$punchFrom and !$punchTo)
                            {

                                //TODO :ADD to Config the case it's below
                                if($paidLeave or $holidays or $weeklyOffDay or $travel)
                                {
                                    $journal->setComputedFrom($slot->getSlotFrom());
                                    $journal->setComputedTo($slot->getSlotTo());
                                }
                                else
                                {
                                    $journal->setDayOff(true);
                                }
                            }
                            elseif(!$punchFrom)
                            {
                                $output->writeln(sprintf(" Punch from \"%s\" to \"%s\"..."
                                    , 'null'
                                    , $punchTo->getPunchTime()->format('G:i')));

                                //-----
                                //--Check Computed From
                                //--------------------------------------

                                $newComputedFrom = null;
                                if($NULL_FROM_PUNCH_CONFIG){
                                    switch ($NULL_FROM_PUNCH_CONFIG->getConfigValue()) {
                                        case -1 :
                                            //$newComputedFrom = null;
                                            break;

                                        case 0 :
                                            $newComputedFrom = date_create();
                                            date_timestamp_set($newComputedFrom, $slot->getSlotFrom()->getTimestamp());
                                            //$newComputedFrom = new \Datetime($slot->getSlotFrom()->getTimestamp());
                                            break;
                                        default : // N > 0
                                            $newComputedFrom = $NULL_FROM_PUNCH_CONFIG->addValueAsMinutesFrom($slot->getSlotFrom());
                                    }
                                }

                                //Set Computed From
                                $journal->setComputedFrom($newComputedFrom);

                                //----
                                //--Check Computed To
                                //--check the retard statment
                                //----------------------------------

                                if($RETARD_TO) {
                                    $retardTo = $RETARD_TO->getConfigValue();

                                    $diff=$this->DiffernceInSeconde($punchTo->getPunchTime(),
                                        $slot->getSlotTo());

                                    if ($diff>=$retardTo and $punchTo<$slot->getSlotTo()) {

                                        $newComputedTo = null;
                                        if ($RETARD_TO_VALUE) {
                                            switch ($RETARD_TO_VALUE->getConfigValue()) {
                                                case -1 :
                                                    //$newComputedTo = null;
                                                    break;

                                                case 0 :
                                                    $newComputedTo = date_create();
                                                    date_timestamp_set($newComputedTo, $slot->getSlotTo()->getTimestamp());
                                                    //$newComputedFrom = new \Datetime($slot->getSlotFrom()->getTimestamp());
                                                    break;
                                                default : // N > 0
                                                    $newComputedTo = $RETARD_TO_VALUE->deductValueAsMinutesFrom($slot->getSlotTo());
                                            }
                                        }
                                        //Set Computed To
                                        $journal->setComputedTo($newComputedTo);
                                    }
                                    else
                                    {
                                        $journal->setComputedTo($slot->getSlotTo());
                                    }
                                }
                            }
                            elseif(!$punchTo)
                            {
                                $output->writeln(sprintf(" Punch from \"%s\" to \"%s\"..."
                                    , $punchFrom->getPunchTime()->format('G:i')
                                    , 'null'));

                                //----
                                //--set Computed from switch config "NULL_TO_PUNCH"
                                //----------------------------------------------------


                                $newComputedTo = null;
                                if($NULL_TO_PUNCH_CONFIG){
                                    switch ($NULL_TO_PUNCH_CONFIG->getConfigValue()) {
                                        case -1 :
                                            //$newComputedTo = null;
                                            break;

                                        case 0 :
                                            $newComputedTo = date_create();
                                            date_timestamp_set($newComputedTo, $slot->getSlotTo()->getTimestamp());
                                            //$newComputedTo = new \Datetime($slot->getSlotTo()->getTimestamp());
                                            break;
                                        default : // N > 0
                                            $newComputedTo = $NULL_TO_PUNCH_CONFIG->deductValueAsMinutesFrom($slot->getSlotTo());
                                    }
                                }

                                //Set Computed To
                                $journal->setComputedTo($newComputedTo);

                                //-----
                                //--set Computed From
                                //--check the retard statment
                                //----------------------------------

                                if($RETARD_FROM) {
                                    $retardFrom = $RETARD_FROM->getConfigValue();

                                    $diff=$this->DiffernceInSeconde($punchFrom->getPunchTime(),
                                        $slot->getSlotFrom());

                                    if ($diff>=$retardFrom and $punchFrom>$slot->getSlotFrom())
                                    {
                                        $newComputedFrom = null;
                                        if ($RETARD_FROM_VALUE) {
                                            switch ($RETARD_FROM_VALUE->getConfigValue()) {
                                                case -1 :
                                                    //$newComputedFrom = null;
                                                    break;

                                                case 0 :
                                                    $newComputedFrom = date_create();
                                                    date_timestamp_set($newComputedFrom, $slot->getSlotFrom()->getTimestamp());
                                                    //$newComputedFrom = new \Datetime($slot->getSlotFrom()->getTimestamp());
                                                    break;
                                                default : // N > 0
                                                    $newComputedFrom = $RETARD_FROM_VALUE->addValueAsMinutesFrom($slot->getSlotFrom());
                                            }
                                        }
                                        //Set Computed From
                                        $journal->setComputedFrom($newComputedFrom);
                                    }
                                    else {
                                        $journal->setComputedFrom($slot->getSlotFrom());
                                    }
                                }
                            }
                            else
                            {
                                $output->writeln(sprintf(" Punch from \"%s\" to \"%s\"..."
                                    , $punchFrom->getPunchTime()->format('G:i')
                                    , $punchTo->getPunchTime()->format('G:i')));

                                //----
                                //--Check Computed To
                                //--check the retard statment
                                //----------------------------------

                                if($RETARD_TO) {
                                    $retardTo = $RETARD_TO->getConfigValue();

                                    $diff=$this->DiffernceInSeconde($punchTo->getPunchTime(),
                                                                    $slot->getSlotTo());

                                    if ($diff>=$retardTo and $punchTo<$slot->getSlotTo()) {

                                        $newComputedTo = null;
                                        if ($RETARD_TO_VALUE) {
                                            switch ($RETARD_TO_VALUE->getConfigValue()) {
                                                case -1 :
                                                    //$newComputedTo = null;
                                                    break;

                                                case 0 :
                                                    $newComputedTo = date_create();
                                                    date_timestamp_set($newComputedTo, $slot->getSlotTo()->getTimestamp());
                                                    //$newComputedFrom = new \Datetime($slot->getSlotFrom()->getTimestamp());
                                                    break;
                                                default : // N > 0
                                                    $newComputedTo = $RETARD_TO_VALUE->deductValueAsMinutesFrom($slot->getSlotTo());
                                            }
                                        }
                                        //Set Computed To
                                        $journal->setComputedTo($newComputedTo);
                                    }
                                    else
                                    {
                                        $journal->setComputedTo($slot->getSlotTo());
                                    }
                                }

                                //-----
                                //--set Computed From
                                //--check the retard statment
                                //----------------------------------

                                if($RETARD_FROM) {
                                    $retardFrom = $RETARD_FROM->getConfigValue();

                                    $diff=$this->DiffernceInSeconde($punchFrom->getPunchTime(),
                                        $slot->getSlotFrom());

                                    if ($diff>=$retardFrom and $punchFrom>$slot->getSlotFrom())
                                    {
                                        $newComputedFrom = null;
                                        if ($RETARD_FROM_VALUE) {
                                            switch ($RETARD_FROM_VALUE->getConfigValue()) {
                                                case -1 :
                                                    //$newComputedFrom = null;
                                                    break;

                                                case 0 :
                                                    $newComputedFrom = date_create();
                                                    date_timestamp_set($newComputedFrom, $slot->getSlotFrom()->getTimestamp());
                                                    //$newComputedFrom = new \Datetime($slot->getSlotFrom()->getTimestamp());
                                                    break;
                                                default : // N > 0
                                                    $newComputedFrom = $RETARD_FROM_VALUE->addValueAsMinutesFrom($slot->getSlotFrom());
                                            }
                                        }
                                        //Set Computed From
                                        $journal->setComputedFrom($newComputedFrom);
                                    }
                                    else {
                                        $journal->setComputedFrom($slot->getSlotFrom());
                                    }
                                }
                            }

                            // save the journal entry to database
                            $entityManager->persist($journal);
                            $entityManager->flush();
                        }
                    }
                    else {
                        $output->writeln(sprintf("NotFound Slots for \"%s\" in \"%s\"..."
                            , $employee->getFirstName()
                            , $date->format('d/m/Y')));
                    }
                }
                else
                {
                    //----
                    //--Create Object DailyWorkJournal
                    //--For each activeEmployees
                    //-----------------------------------------

                    $journal = new DailyWorkJournal();

                    //----
                    //--fill the table with known field
                    //--and set the not known field as NULL
                    //--------------------------------------

                    $journal->setAsDate($date);
                    $journal->setSlotFrom(null);
                    $journal->setSlotTo(null);
                    $journal->setComputedFrom(null);
                    $journal->setComputedTo(null);
                    $journal->setDayOff(false);
                    $journal->setWeeklyDayOff(false);
                    $journal->setTravel(null);
                    $journal->setPaidLeave(null);
                    $journal->setMachineInterfaceFrom(null);
                    $journal->setMachineInterfaceTo(null);
                    $journal->setEmployee($employee);
                    $journal->setHoliday(null);

                    if($paidLeave)
                        $journal->setPaidLeave($paidLeave);

                    if($holidays)
                        $journal->setHoliday($holidays);

                    if($travel)
                        $journal->setTravel($travel);

                    // save the journal entry to database
                    $entityManager->persist($journal);
                    $entityManager->flush();
                }

            }
        }
        else
            $output->writeln(sprintf('NotFound Active Employee in "%s"...', $date->format('d/m/Y')));

    }

    /*
    *
    * return punchTo
    *
    * TypeRetourn DateTime
    */
    public function getPunchTo($slot, $employee, $date)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $punches = $qb->select('p')
            ->from('AGEPEAdminBundle:MachineInterface','p')
            ->where('p.importDate = :date')
            ->andWhere('p.punchTime BETWEEN :minTo AND :maxTo')
            ->andWhere('p.employee = :employee')
            ->andWhere($qb->expr()->isNull('p.treatedDate'))
            ->setParameter('date',$date->format('Y-m-d'))
            ->setParameter('employee',$employee)
            ->setParameter('minTo',$slot->getMinTo()->format('G:i'))
            ->setParameter('maxTo',$slot->getMaxTo()->format('G:i'))
            ->getQuery()
            ->getResult();

        return $punches ? $this->closerPunch($punches, $slot->getSlotTo(), $date) : null ;
    }

    /*
    *
    * return punchFrom
    *
    * TypeRetourn MachineInterface
    */
    public function getPunchFrom($slot, $employee, $date)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $punches = $qb->select('p')
            ->from('AGEPEAdminBundle:MachineInterface','p')
            ->where('p.importDate = :date')
            ->andWhere('p.punchTime BETWEEN :minFrom AND :maxFrom')
            ->andWhere('p.employee = :employee')
            ->andWhere($qb->expr()->isNull('p.treatedDate'))
            ->setParameter('date',$date->format('Y-m-d'))
            ->setParameter('employee',$employee)
            ->setParameter('minFrom',$slot->getMinFrom()->format('G:i'))
            ->setParameter('maxFrom',$slot->getMaxFrom()->format('G:i'))
            ->getQuery()
            ->getResult();

        return $punches ? $this->closerPunch($punches, $slot->getSlotFrom(), $date) : null ;

    }


    /*
    *
    * return the most closer punch to $slot
    *
    * TypeRetourn MachineInterface Object
    */
    public function closerPunch($punches, $slot, $date)
    {
        $punchCloser=$punches[0];
        $min=$this->DiffernceInSeconde($punches[0]->getPunchTime(), $slot);
        foreach ($punches as $punch)
        {
            $var=$this->DiffernceInSeconde($punch->getPunchTime(), $slot);
            if($var<$min)
            {
                $punchCloser=$punch;
                $min=$var;
            }
        }
        $this->UpdateFieldTreatedDate($punchCloser->getId(), $date);
        return $punchCloser;
    }

    /*
    *
    * Update field treated
    *
    *
    */
    protected function UpdateFieldTreatedDate($id,$date)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->update('AGEPEAdminBundle:MachineInterface','m')
            ->set('m.treatedDate',$qb->expr()->literal($date->format('Y-m-d')))
            ->where('m.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->execute();
    }

    /*
    *
    * return Difference in seconde between two dateTime
    *
    * TypeRetourn Value
    */
    protected function DiffernceInSeconde($time_one,$time_two)
    {
        $Interval=DATE_DIFF($time_one,$time_two);
        $result=($Interval->h*60*60+$Interval->i*60+$Interval->s);
        return $result;
    }


    /*
     *
     * return if an employee have travel in $date
     *
     * TypeRetourn is Single Object Travel or NULL
     */
    public function CheckTravel($employee, $date)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $travel = $qb->select('t')
            ->from('AGEPEAdminBundle:Travel','t')
            ->where(':date BETWEEN t.fromDate AND t.toDate')
            ->andWhere('t.employee = :employee')
            ->setParameter('date',$date->format('Y-m-d'))
            ->setParameter('employee',$employee)
            ->getQuery()
            ->getOneOrNullResult();

        return $travel;

    }

    /*
     *
     * return shift for an $employee compared an $date
     *
     * TypeRetourn is Single Object TimeShift or NULL
     */
    public function getEmployeeCurrentShift($employee, $date)
    {

        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $qb=$entityManager->createQueryBuilder();

        $getAllAssignment =$qb->select('a')
            ->from('AGEPEAdminBundle:Assignment','a')
            ->where('a.employee = :employee')
            ->andwhere(':date >= a.fromDate ')
            ->andwhere('a.toDate IS NULL OR :date <= a.toDate')
            ->setParameter('date',$date->format('Y-m-d'))
            ->setParameter('employee',$employee)
            ->getQuery()
            ->getResult();

        if($getAllAssignment!=null)
        {
            $id=$getAllAssignment[0]->getId();

            if($getAllAssignment[0]->getToDate()==null)
            {
                $dat =  \DateTime::createFromFormat( 'Y-m-d', '0000-00-00' ) ;
                $min=DATE_DIFF($dat,$date);
            }
            else
            {
                $dat=$getAllAssignment[0]->getToDate();
                $min=DATE_DIFF($dat,$date);
            }
            foreach ($getAllAssignment as $gaa)
            {
                //var_dump(DATE_DIFF($dat,$date)->days,$id);die();
                if($gaa->getToDate()==null)
                {
                    $dat =  \DateTime::createFromFormat( 'Y-m-d', '0000-00-00' ) ;
                }
                else
                {
                    $dat =$gaa->getToDate();
                }

                if(DATE_DIFF($dat,$date)->days < $min->days)
                {
                    $min=DATE_DIFF($dat,$date);
                    //var_dump($min->days);
                    $id=$gaa->getId();
                }
            }


            $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
            // find all shift of employee in date
            // -----------------------------------
            $qbb=$entityManager->createQueryBuilder();

            $getResultAssignment =$qbb->select('ass')
                ->from('AGEPEAdminBundle:Assignment','ass')
                ->where('ass.id = :idd')
                ->setParameter('idd',$id)
                ->getQuery()
                ->getSingleResult();
        }
        return $getAllAssignment ? $getResultAssignment->getTimeShift() : null ;
    }

    /*
     *
     * return Paid_leave for an $employee compared an $date
     *
     * TypeRetourn is Single Object PaidLeave or NULL
     */
    public function CheckPaidLeave($date,$employee)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

        $paidLeave = $qb->select('p')
            ->from('AGEPEAdminBundle:PaidLeave','p')
            ->where(':date BETWEEN p.fromDate AND p.toDate')
            ->andWhere('p.employee = :employee')
            ->setParameter('date',$date->format('Y-m-d'))
            ->setParameter('employee',$employee)
            ->getQuery()
            ->getOneOrNullResult();

        return $paidLeave ;
    }

    /*
     *
     * return list of employee Active compared an $date
     *
     * TypeRetourn is list<Employee> or NULL
     */
    public function ActiveEmployee($date)
    {

        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

            $qb->update('AGEPEAdminBundle:Employee', 'e')
            ->set('e.departureDate', '?1')
            ->setParameter(1, null)
            ->where('e.departureDate=\'0000-00-00\'')
            ->getQuery()
            ->execute();

        $qb = $entityManager->createQueryBuilder();

        $activeEmployees = $qb->select('e')
            ->from('AGEPEAdminBundle:Employee','e')
            ->where($qb->expr()->isNull('e.departureDate'))
            ->orwhere('e.departureDate > :date')
            ->setParameter('date',$date->format('Y-m-d'))
            ->getQuery()
            ->getResult();

        return $activeEmployees;
    }

    /*
     *
     * return list of Holidays compared an $date
     *
     * TypeRetourn is list<Holiday> or NULL
     */
    public function CheckHoliday($date)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

        $holiday = $qb->select('h')
            ->from('AGEPEAdminBundle:Holiday','h')
            ->where('h.holidayDate = :date')
            ->setParameter('date',$date->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();

        return $holiday;
    }

}

