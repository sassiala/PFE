<?php

/**
 * Created by PhpStorm.
 * User: ALA
 * Date: 20-05-2017
 * Time: 20:29
 */

namespace AGEPE\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AGEPE\AdminBundle\Entity\Employee;
use AGEPE\AdminBundle\Form\EmployeeType;


/**
 * Employee controller.
 *
 * @Route("/MachineInterface")
 */
class MachineInterfaceController extends Controller
{
    /**
     * Lists all Employee entities.
     *
     * @Route("/index", name="MachineInterface")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AGEPEAdminBundle:MachineInterface')->findAll();


        return $this->render('AGEPEAdminBundle:MachineInterface:index.html.twig',
            array('entities' => $entities));
    }
}