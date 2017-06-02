<?php

namespace AGEPE\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AGEPE\AdminBundle\Entity\Assignment;
use AGEPE\AdminBundle\Form\AssignmentType;

/**
 * Assignment controller.
 *
 * @Route("/assignment")
 */

class AssignmentController extends Controller
{

    /**
     * Lists all Assignment entities by Employee.
     *
     * @Route("/emp/{id}", name="assignment_by_employee")
     * @Template()
     */
    public function assignmentByEmployeeAction($id, Request $request)
    {
/*
 * ///use it for extract the id number from the shift name field
        $string="11 ala 1126";
        preg_match_all('/([\d]+)/', $string, $match);

        var_dump($match[0][0]);die();
*/
        $em = $this->getDoctrine()->getManager();


        $slots=$em->createQueryBuilder()->select('s')
            ->from('AGEPEAdminBundle:TimeSlot', 's')
            ->getQuery()
            ->getResult();

        $employee=$em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        $shifts=$em->createQueryBuilder()->select('s')
            ->from('AGEPEAdminBundle:TimeShift', 's')
            ->getQuery()
            ->getResult();



        if ($request->isMethod('POST')) {
            $date = $request->request->get('asDate');


            $entities = $em->createQueryBuilder()->select('a')
                ->from('AGEPEAdminBundle:Assignment', 'a')
                ->where('a.employee = :employee')
                ->andwhere(':date >= a.fromDate ')
                ->andwhere('a.toDate IS NULL OR :date <= a.toDate')
                ->setParameter('employee',$employee)
                ->setParameter('date', $date)
                ->getQuery()
                ->getResult();

            $array = array();
            if ($entities) {
                foreach ($entities as $entity) {
                    if ($entity->getToDate() != null) {
                        array_push($array, $entity);
                    }
                }
            }



            if ($array) {
                return $this->render('AGEPEAdminBundle:Assignment:assignmentByEmployee.html.twig',
                    array('entities' => $array,'employee'=>$employee, 'date' => $date, 'slots' => $slots, 'shifts'=>$shifts));
            } else {
                return $this->render('AGEPEAdminBundle:Assignment:assignmentByEmployee.html.twig',
                    array('entities' => $entities, 'employee'=>$employee, 'date' => $date, 'slots' => $slots, 'shifts'=>$shifts));
            }

        }

        $employee=$em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        $entities=$em->createQueryBuilder()->select('a')
            ->from('AGEPEAdminBundle:Assignment', 'a')
            ->where('a.employee = :employee')
            ->setParameter('employee',$employee)
            ->getQuery()
            ->getResult();


        if($entities)
            return $this->render('AGEPEAdminBundle:Assignment:assignmentByEmployee.html.twig',
                array('entities'=>$entities,
                    'employee'=>$employee,
                    'date' => null,
                    'slots' => $slots,
                    'shifts'=>$shifts));
        else
            return $this->render('AGEPEAdminBundle:Assignment:assignmentByEmployee.html.twig',
                array('entities'=>null,
                    'employee'=>$employee,
                    'date' => null,
                    'slots' => $slots,
                    'shifts'=>$shifts));

    }


    /**
     * Lists all Assignment entities by Employee.
     *
     * @Route("/add/{id}", name="assignment_add")
     */

    public function assignmentAdd($id, Request $request)
    {
        if($request->isMethod('post'))
        {
            $em = $this->getDoctrine()->getManager();

            $employee=$em->getRepository('AGEPEAdminBundle:Employee')->find($id);
            $fromDate=$request->request->get('fromDate');
            $toDate=$request->request->get('toDate');
            $shift_form=$request->request->get('Shift');
            preg_match_all('/([\d]+)/', $shift_form, $id_shift);

            $shift=$em->getRepository('AGEPEAdminBundle:TimeShift')->find($id_shift[0][0]);

            $assignment = new Assignment();
            $assignment->setEmployee($employee);
            $assignment->setFromDate(\DateTime::createFromFormat( 'Y-m-d', $fromDate ));
            $assignment->setTimeShift($shift);
            if($toDate==null)
            {

                $assignment->setToDate(null);
            }
            else
            {

                $assignment->setToDate(\DateTime::createFromFormat( 'Y-m-d', $toDate ));
            }
            $em->persist($assignment);
            $em->flush();

            return $this->redirect($this->generateUrl('assignment_by_employee',
                array('id' => $id)));

        }
        return $this->redirect($this->generateUrl('assignment_by_employee',
            array('id' => $id)));;
    }


    /**
     * Lists all Assignment entities.
     *
     * @Route("/index", name="assignment")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AGEPEAdminBundle:Assignment')->findAll();

        if ($request->isMethod('POST')) {
            $date = $request->request->get('asDate');

            $entities = $em->createQueryBuilder()->select('a')
                ->from('AGEPEAdminBundle:Assignment', 'a')
                ->andwhere(':date >= a.fromDate ')
                ->andwhere('a.toDate IS NULL OR :date <= a.toDate')
                ->setParameter('date', $date)
                ->getQuery()
                ->getResult();


            if ($entities) {
                return $this->render('AGEPEAdminBundle:Assignment:index.html.twig',
                    array('entities' => $entities, 'date' => $date));
            } else {
                return $this->render('AGEPEAdminBundle:Assignment:index.html.twig',
                    array('entities' => null, 'date' => $date));
            }

        }

        return array(
            'entities' => $entities, 'date' => null
        );
    }


    /**
     * Finds and displays a Assignment entity.
     *
     * @Route("/{id}/show", name="assignment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Assignment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Assignment entity.');
        }

        /*
        * prendre id assignment
        *
        */

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Assignment entity.
     *
     * @Route("/{id}/edit", name="assignment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)//id of Assignment
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Assignment')->find($id);

        $slots=$em->getRepository('AGEPEAdminBundle:TimeSlot')->findAll();

        $shifts=$em->getRepository('AGEPEAdminBundle:TimeShift')->findAll();

        return $this->render('AGEPEAdminBundle:Assignment:edit.html.twig',
            array('entity'=>$entity,
                'slots'=>$slots,
                'shifts'=>$shifts));
    }


}