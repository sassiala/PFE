/**
* Displays a form to edit an existing Assignment entity.
*
* @Route("/{id}/edit", name="assignment_edit")
* @Method("GET")
* @Template()
*/
public function editAction($id)
{
$em = $this->getDoctrine()->getManager();

$entity = $em->getRepository('AGEPEAdminBundle:Assignment')->find($id);

if (!$entity) {
throw $this->createNotFoundException('Unable to find Assignment entity.');
}

$editForm = $this->createEditForm($entity);

return array(
'entity'      => $entity,
'edit_form'   => $editForm->createView(),
);
}

/**
* Creates a form to edit a Assignment entity.
*
* @param Assignment $entity The entity
*
* @return \Symfony\Component\Form\Form The form
*/
private function createEditForm(Assignment $entity)
{
$form = $this->createForm(new AssignmentType(), $entity, array(
'action' => $this->generateUrl('assignment_update', array('id' => $entity->getId())),
'method' => 'PUT',
));

$form->add('submit', 'submit', array('label' => 'Update'));

return $form;
}

/**
* Edits an existing Assignment entity.
*
* @Route("/{id}", name="assignment_update")
* @Method("PUT")
* @Template("AGEPEAdminBundle:Assignment:edit.html.twig")
*/
public function updateAction(Request $request, $id)
{
$em = $this->getDoctrine()->getManager();

$entity = $em->getRepository('AGEPEAdminBundle:Assignment')->find($id);

if (!$entity) {
throw $this->createNotFoundException('Unable to find Assignment entity.');
}
$editForm = $this->createEditForm($entity);
$editForm->handleRequest($request);

if ($editForm->isValid()) {
$em->flush();

return $this->redirect($this->generateUrl('assignment_edit', array('id' => $id)));
}

return array(
'entity'      => $entity,
'edit_form'   => $editForm->createView(),
);
}







/**
* Creates a new Assignment entity.
*
* @Route("/", name="assignment_create")
* @Method("POST")
* @Template("AGEPEAdminBundle:Assignment:new.html.twig")
*/
public function createAction(Request $request)
{
$entity = new Assignment();
$form = $this->createCreateForm($entity);
$form->handleRequest($request);

if ($form->isValid()) {
$em = $this->getDoctrine()->getManager();
$em->persist($entity);
$em->flush();

return $this->redirect($this->generateUrl('assignment_show', array('id' => $entity->getId())));
}

return array(
'entity' => $entity,
'form'   => $form->createView(),
);
}

/**
* Creates a form to create a Assignment entity.
*
* @param Assignment $entity The entity
*
* @return \Symfony\Component\Form\Form The form
*/
private function createCreateForm(Assignment $entity)
{
$form = $this->createForm(new AssignmentType(), $entity, array(
'action' => $this->generateUrl('assignment_create'),
'method' => 'POST',
));

$form->add('submit', 'submit', array('label' => 'Create'));

return $form;
}

/**
* Displays a form to create a new Assignment entity.
*
* @Route("/new/{id}", name="assignment_new")
* @Template()
*/
public function newAction($id)
{
$entity = new Assignment();
$form   = $this->createCreateForm($entity);

return array(
'entity' => $entity,
'form'   => $form->createView(),
);
}





/**
* Deletes a Assignment entity.
*
* @Route("/{id}", name="assignment_delete")
* @Method("DELETE")
*/
public function deleteAction(Request $request, $id)
{
$form = $this->createDeleteForm($id);
$form->handleRequest($request);

if ($form->isValid()) {
$em = $this->getDoctrine()->getManager();
$entity = $em->getRepository('AGEPEAdminBundle:Assignment')->find($id);

if (!$entity) {
throw $this->createNotFoundException('Unable to find Assignment entity.');
}

$em->remove($entity);
$em->flush();
}

return $this->redirect($this->generateUrl('assignment'));
}

/**
* Creates a form to delete a Assignment entity by id.
*
* @param mixed $id The entity id
*
* @return \Symfony\Component\Form\Form The form
*/
private function createDeleteForm($id)
{
return $this->createFormBuilder()
->setAction($this->generateUrl('assignment_delete', array('id' => $id)))
->setMethod('DELETE')
->add('submit', 'submit', array('label' => 'Delete'))
->getForm()
;
}
}
