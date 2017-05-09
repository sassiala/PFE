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
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:DailyWorkJournal')->findAll();
   /*     $array=array();
        $i=0;
        foreach ($entity as $e)
        {
            $bool=true;
            if($array)
            {
                //if($array[$i]['date']==$e->getAsDate() and $array[$i]['employee']==$e->getEmployee())
                {
                    $bool=false;
                }
            }


            if($bool)//$entity n'existe pas dans l'array => add ligne
            {
                array_push($array,
                    array('date'=>$e->getAsDate(),
                            'employee'=>$e->getEmployee(),
                        'slotFrom'=>$e->getSlotFrom(),
                        'slotTo'=>$e->getSlotTo(),
                        'slot2From'=>null,
                        'slot2To'=>null,

                        'computedFrom'=>$e->getComputedFrom(),
                        'computedTo'=>$e->getComputedTo(),
                        'computed2From'=>null,
                        'computed2To'=>null,

                        'punchFrom'=>$e->getMachineInterfaceFrom(),
                        'punchTo'=>$e->getMachineInterfaceTo(),
                        'punch2From'=>null,
                        'punch2To'=>null,

                        'paidLeave'=>$e->getPaidLeave(),
                        'paid2Leave'=>$e->getPaidLeave(),

                        'holiday'=>$e->getHoliday(),
                        'dayOff'=>$e->getDayOff(),
                        'weeklyDayOff'=>$e->getweeklyDayOff(),
                        'travel'=>$e->getTravel(),
                        ));
                $i++;
            }
            else
            {
                $array[$i]['slot2From']=$e->getSlotFrom();
                $array[$i]['slot2To']=$e->getSlotTo();
                $array[$i]['computed2From']=$e->getComputedFrom();
                $array[$i]['computed2To']=$e->getComputedTo();
                $array[$i]['punch2From']=$e->getMachineInterfaceFrom();
                $array[$i]['punch2To']=$e->getMachineInterfaceTo();
                $array[$i]['paid2Leave']=$e->getPaidLeave();
            }
        }

        var_dump(sizeof($array));
        die();
        foreach ($array as $a=>$arr)
        {
            foreach ($arr as $b)
            {
                    var_dump('fuck');
            }
        }
        die();
*/
        return $this->render('AGEPEAdminBundle:DailyWorkJournal:index.html.twig',
            array('entities'=>$entity));
    }
}