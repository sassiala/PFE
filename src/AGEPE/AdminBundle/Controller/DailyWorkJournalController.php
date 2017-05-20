<?php
/**
 * Created by PhpStorm.
 * User: ALA
 * Date: 02-05-2017
 * Time: 20:54
 */

namespace AGEPE\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AGEPE\AdminBundle\Entity\DailyWorkJournal;
/**
 * DailyWorkJournal controller.
 *
 * @Route("/DailyWorkJournal")
 */
class DailyWorkJournalController extends Controller
{
    /**
     * Lists all DailyWorkJournal entities.
     *
     * @Route("/", name="DailyWorkJournal")
     * @Template()
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:DailyWorkJournal')->findAll();

        $array = array();
        $i = 0;
        foreach ($entity as $e) {

            $bool = true;
            if ($array) {
                if ($array[$i-1]['date'] == $e->getAsDate() and $array[$i-1]['employee'] == $e->getEmployee()) {
                    $bool = false;
                }
            }

            if ($bool)//$entity n'existe pas dans l'array => add ligne
            {
                array_push($array,
                    array(
                        'id'            =>$e->getId(),
                        'date'          => $e->getAsDate(),
                        'employee'      => $e->getEmployee(),
                        'slotFrom'      => $e->getSlotFrom(),
                        'slotTo'        => $e->getSlotTo(),
                        'slot2From'     => null,
                        'slot2To'       => null,

                        'computedFrom'  => $e->getComputedFrom(),
                        'computedTo'    => $e->getComputedTo(),
                        'computed2From' => null,
                        'computed2To'   => null,

                        'punchFrom'     => $e->getMachineInterfaceFrom(),
                        'punchTo'       => $e->getMachineInterfaceTo(),
                        'punch2From'    => null,
                        'punch2To'      => null,

                        'paidLeave'     => $e->getPaidLeave(),
                        'paid2Leave'    => null,

                        'holiday'       => $e->getHoliday(),
                        'dayOff'        => $e->getDayOff(),
                        'weeklyDayOff'  => $e->getWeeklyDayOff(),
                        'travel'        => $e->getTravel(),
                    ));
                $i++;
            }
            else {

                $array[$i-1]['slot2From']       = $e->getSlotFrom();
                $array[$i-1]['slot2To']         = $e->getSlotTo();
                $array[$i-1]['computed2From']   = $e->getComputedFrom();
                $array[$i-1]['computed2To']     = $e->getComputedTo();
                $array[$i-1]['punch2From']      = $e->getMachineInterfaceFrom();
                $array[$i-1]['punch2To']        = $e->getMachineInterfaceTo();
                $array[$i-1]['paid2Leave']      = $e->getPaidLeave();


                if($array[$i-1]['dayOff'] and $e->getDayOff())
                    $array[$i-1]['dayOff']=true;
                else
                    $array[$i-1]['dayOff']=false;



            }
        }
        return $this->render('AGEPEAdminBundle:DailyWorkJournal:index.html.twig',
            array('entities' => $array));
    }

    /**
     * Lists all DailyWorkJournal entities.
     *
     * @Route("/{id}/show/", name="DailyWorkJournal_show")
     * @Template()
     */
    public function showDWJAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:DailyWorkJournal')->findAll();

        $array = array();
        $i = 0;
        foreach ($entity as $e) {

            $bool = true;
            if ($array) {
                if ($array[$i-1]['date'] == $e->getAsDate() and $array[$i-1]['employee'] == $e->getEmployee()) {
                    $bool = false;
                }
            }

            if ($bool)//$entity n'existe pas dans l'array => add ligne
            {
                array_push($array,
                    array(
                        'id'            =>$e->getId(),
                        'date'          => $e->getAsDate(),
                        'employee'      => $e->getEmployee(),
                        'slotFrom'      => $e->getSlotFrom(),
                        'slotTo'        => $e->getSlotTo(),
                        'slot2From'     => null,
                        'slot2To'       => null,

                        'computedFrom'  => $e->getComputedFrom(),
                        'computedTo'    => $e->getComputedTo(),
                        'computed2From' => null,
                        'computed2To'   => null,

                        'punchFrom'     => $e->getMachineInterfaceFrom(),
                        'punchTo'       => $e->getMachineInterfaceTo(),
                        'punch2From'    => null,
                        'punch2To'      => null,

                        'paidLeave'     => $e->getPaidLeave(),
                        'paid2Leave'    => null,

                        'holiday'       => $e->getHoliday(),
                        'dayOff'        => $e->getDayOff(),
                        'weeklyDayOff'  => $e->getWeeklyDayOff(),
                        'travel'        => $e->getTravel(),
                    ));
                $i++;
            }
            else {

                $array[$i-1]['slot2From']       = $e->getSlotFrom();
                $array[$i-1]['slot2To']         = $e->getSlotTo();
                $array[$i-1]['computed2From']   = $e->getComputedFrom();
                $array[$i-1]['computed2To']     = $e->getComputedTo();
                $array[$i-1]['punch2From']      = $e->getMachineInterfaceFrom();
                $array[$i-1]['punch2To']        = $e->getMachineInterfaceTo();
                $array[$i-1]['paid2Leave']      = $e->getPaidLeave();


                if($array[$i-1]['dayOff'] and $e->getDayOff())
                    $array[$i-1]['dayOff']=true;
                else
                    $array[$i-1]['dayOff']=false;



            }
        }

        foreach ($array as $a)
        {
            if($a['id']==$id)
            {
                return $this->render('AGEPEAdminBundle:DailyWorkJournal:showDWJ.html.twig',
                    array('entity' => $a));
            }
        }
    }
}