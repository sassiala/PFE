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
     * @Route("/", name="employee")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AGEPEAdminBundle:Employee')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Employee entity.
     *
     * @Route("/", name="employee_create")
     * @Method("POST")
     * @Template("AGEPEAdminBundle:Employee:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Employee();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            //TODO: verifier l'existance d'Identification number
            //TODO: doit etre unique
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('employee_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
    public function newAction()
    {
        $entity = new Employee();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Employee entity.
     *
     * @Route("/{id}", name="employee_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $deleteForm = $this->createOutForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Employee entity.
     *
     * @Route("/{id}/edit", name="employee_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createOutForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Employee entity.
     *
     * @Route("/{id}", name="employee_update")
     * @Method("PUT")
     * @Template("AGEPEAdminBundle:Employee:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $deleteForm = $this->createOutForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('employee_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Employee entity.
     *
     * @Route("/{id}", name="employee_out")
     *
     */
    public function DepatureAction(Request $request, $id)
    {

        $form = $this->createOutForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {

            //var_dump($form->get('date')->getData()->format('Y-m-d'));die();
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Employee entity.');
            }
            $departure_date=$form->get('date')->getData();
            $q = $em->createQueryBuilder()
                ->update('AGEPEAdminBundle:Employee', 'e')
                ->set('e.departureDate',':date')
                ->where('e.id = :id')
                ->setParameter('id', $id)
                ->setParameter('date',$departure_date->format('Y-m-d') )
                ->getQuery()
                ->execute();

            return $this->redirect($this->generateUrl('employee_show',array('id'=>$id)));

        }

        return $this->redirect($this->generateUrl('employee'));
    }
    /*public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AGEPEAdminBundle:Employee')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Employee entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('employee'));
    }*/

    /**
     * Creates a form to delete a Employee entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createOutForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employee_out', array('id' => $id)))
            ->add('date','date',array('data' => new \DateTime("now")))
            ->add('submit', 'submit', array('label' => 'Contract Finished'))
            ->getForm()
        ;
    }
}
