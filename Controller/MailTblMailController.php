<?php

namespace Orca\MailBundle\Controller;

use Orca\MailBundle\Entity\MailTblMail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mailtblmail controller.
 *
 * @Route("mailtblmail")
 */
class MailTblMailController extends Controller
{
    /**
     * Lists all mailTblMail entities.
     *
     * @Route("/", name="mailtblmail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mailTblMails = $em->getRepository('OrcaMailBundle:MailTblMail')->findAll();

        return $this->render('OrcaMailBundle:mailtblmail:index.html.twig', array(
            'mailTblMails' => $mailTblMails,
        ));
    }

    /**
     * Creates a new mailTblMail entity.
     *
     * @Route("/new", name="mailtblmail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mailTblMail = new Mailtblmail();
        $form = $this->createForm('Orca\MailBundle\Form\MailTblMailType', $mailTblMail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailTblMail);
            $em->flush();

            return $this->redirectToRoute('mailtblmail_show', array('id' => $mailTblMail->getUserId()));
        }

        return $this->render('OrcaMailBundle:mailtblmail:new.html.twig', array(
            'mailTblMail' => $mailTblMail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mailTblMail entity.
     *
     * @Route("/{id}", name="mailtblmail_show")
     * @Method("GET")
     */
    public function showAction(MailTblMail $mailTblMail)
    {
        $deleteForm = $this->createDeleteForm($mailTblMail);

        return $this->render('OrcaMailBundle:mailtblmail:show.html.twig', array(
            'mailTblMail' => $mailTblMail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mailTblMail entity.
     *
     * @Route("/{id}/edit", name="mailtblmail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MailTblMail $mailTblMail)
    {
        $deleteForm = $this->createDeleteForm($mailTblMail);
        $editForm = $this->createForm('Orca\MailBundle\Form\MailTblMailType', $mailTblMail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mailtblmail_edit', array('id' => $mailTblMail->getUserId()));
        }

        return $this->render('OrcaMailBundle:mailtblmail:edit.html.twig', array(
            'mailTblMail' => $mailTblMail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mailTblMail entity.
     *
     * @Route("/{id}", name="mailtblmail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MailTblMail $mailTblMail)
    {
        $form = $this->createDeleteForm($mailTblMail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mailTblMail);
            $em->flush();
        }

        return $this->redirectToRoute('mailtblmail_index');
    }

    /**
     * Creates a form to delete a mailTblMail entity.
     *
     * @param MailTblMail $mailTblMail The mailTblMail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MailTblMail $mailTblMail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mailtblmail_delete', array('id' => $mailTblMail->getUserId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
