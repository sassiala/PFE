<?php

namespace AGEPE\AdminBundle\Controller;

use AGEPE\AdminBundle\Entity\MachineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AGEPE\AdminBundle\Entity\Employee;
use AGEPE\AdminBundle\Form\EmployeeType;

/**
 * Created by PhpStorm.
 * User: ALA
 * Date: 15-05-2017
 * Time: 19:26
 */

/**
 * Employee controller.
 *
 * @Route("/employee")
 */
class testMachinePunchController extends Controller
{

    /**
     * Lists all Employee entities.
     *
     * @Route("/Machine", name="Machine")
     * @Template("AGEPEAdminBundle:testPunchMachine:Machine.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AGEPEAdminBundle:Employee')->findAll();

        if ($request->isMethod('POST')) {

            $employee = $request->request->get('employee');

            preg_match("|\d+|", $employee, $id);

            $entity = $em->getRepository('AGEPEAdminBundle:Employee')->findOneById($id);

            $CT=new \DateTime("now");

            $machineInterface= new MachineInterface();
            $machineInterface->setEmployee($entity);
            $machineInterface->setTreatedDate(null);
            $machineInterface->setImportDate($CT);
            $machineInterface->setPunchTime($CT);

            $em->persist($machineInterface);
            $em->flush();


            return $this->render('AGEPEAdminBundle:testPunchMachine:Machine.html.twig',
                array('entities'=>$entities));


        }
        return $this->render('AGEPEAdminBundle:testPunchMachine:Machine.html.twig',
            array('entities'=>$entities));
    }

}