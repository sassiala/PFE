<?php

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
 * @Route("/employee")
 */
class EmployeeController extends Controller
{


    /**
     * Lists all Employee entities.
     *
     * @Route("/index", name="employee")
     * @Template()
     */
    public function indexAction(Request $requestIndex)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AGEPEAdminBundle:Employee')->findAll();

        if ($requestIndex->isMethod('POST')) {
            $date = $requestIndex->request->get('asDate');

            $entities = $em->createQueryBuilder()->select('a')
                ->from('AGEPEAdminBundle:Employee', 'a')
                ->andwhere(':date >= a.joinDate ')
                ->andwhere('a.departureDate IS NULL OR :date <= a.departureDate')
                ->setParameter('date', $date)
                ->getQuery()
                ->getResult();


            return $this->render('AGEPEAdminBundle:Employee:indexEmployee.html.twig',
                array('entities' => $entities, 'date' => $date));


        }

        return $this->render('AGEPEAdminBundle:Employee:indexEmployee.html.twig',
            array('entities' => $entities, 'date' => null));
    }

    /**
     * Creates a new Employee entity.
     *
     * @Route("/new/create", name="employee_create")
     * @Method("POST")
     * @Template("AGEPEAdminBundle:Employee:newEmployee.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Employee();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $joinDate=$form->get('joinDate')->getData();
            $departureDate=$form->get('departureDate')->getData();


            if($departureDate<=$joinDate)
                $entity->setDepartureDate(null);


            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('employee_show', array('id' => $entity->getId())));
        }

        return $this->render("AGEPEAdminBundle:Employee:newEmployee.html.twig",
            array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
    }


    /**
     * Creates a form to create a Employee entity.
     *
     * @param Employee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Employee $entity)
    {


        $form = $this->createForm(new EmployeeType(), $entity, array(
            'action' => $this->generateUrl('employee_create'),
            'method' => 'POST',
        ));

        $form->get('joinDate')->setData(new \DateTime("now"));
        $form->get('departureDate')->setData(new \DateTime("00-00-0000"));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Employee entity.
     *
     * @Route("/new", name="employee_new")
     * @Method("GET")
     * @Template()
     */
    public function newEmployeeAction()
    {
        $entity = new Employee();
        $form   = $this->createCreateForm($entity);



        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }






    /**
     * Displays a form to edit an existing Employee entity.
     *
     * @Route("/{id}/edit", name="employee_edit")
     * @Method("GET")
     * @Template()
     */
    public function editEmployeeAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Employee entity.
     *
     * @param Employee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Employee $entity)
    {
        $form = $this->createForm(new EmployeeType(), $entity, array(
            'action' => $this->generateUrl('employee_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        $form->get('joinDate')->setData
        (new \DateTime($entity->getJoinDate()->format('d-m-Y')));

        if($entity->getDepartureDate() == null)
            $form->get('departureDate')->setData(new \DateTime("00-00-0000"));
        else
            $form->get('departureDate')->setData
            (new \DateTime($entity->getDepartureDate()->format('d-m-Y')));


        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Employee entity.
     *
     * @Route("/{id}", name="employee_update")
     * @Method("PUT")
     * @Template("AGEPEAdminBundle:Employee:editEmployee.html.twig")
     */
    public function updateAction(Request $requestUpdate, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

       // $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($requestUpdate);

        if ($editForm->isValid()) {

            $joinDate=$editForm->get('joinDate')->getData();
            $departureDate=$editForm->get('departureDate')->getData();

            if($departureDate<=$joinDate)
                $entity->setDepartureDate(null);

            $em->flush();

            return $this->redirect($this->generateUrl('employee_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a Employee entity.
     *
     * @Route("/{id}/show", name="employee_show")
     * @Method("GET")
     * @Template("AGEPEAdminBundle:Employee:showEmployee.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            //'delete_form' => $deleteForm->createView(),
        );
    }

/*
    /**
     * Deletes a Employee entity.
     *
     * @Route("/{id}/delete", name="employee_delete")
     * @Method("DELETE")
     */
    /*public function deleteAction(Request $requestDelete, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($requestDelete);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

            $entityInAssignment = $em->getRepository('AGEPEAdminBundle:Assignment')->findOneByEmployee($entity);
            $entityInMachineInterface = $em->getRepository('AGEPEAdminBundle:MachineInterface')
                ->findOneByEmployee($entity);


            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Employee entity.');
            }

            if(!$entityInAssignment and !$entityInMachineInterface)
            {
                $em->remove($entity);
                $em->flush();
            }
            else
            {
                return $this->redirect($this->generateUrl('employee_show',array('id'=>$id)));
            }
        }

        return $this->redirect($this->generateUrl('employee'));
    }

    /**
     * Creates a form to delete a Employee entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    /*private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employee_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }*/

}
