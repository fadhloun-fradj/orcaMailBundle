<?php

namespace Orca\MailBundle\Controller;

use Orca\MailBundle\Entity\MailTblMailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mailtblmailtype controller.
 *
 * @Route("mailtblmailtype")
 */
class MailTblMailTypeController extends Controller
{
    /**
     * Lists all mailTblMailType entities.
     *
     * @Route("/", name="mailtblmailtype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mailTblMailTypes = $em->getRepository('OrcaMailBundle:MailTblMailType')->findAll();

        return $this->render('OrcaMailBundle:mailtblmailtype:index.html.twig', array(
            'mailTblMailTypes' => $mailTblMailTypes,
        ));
    }

    /**
     * Creates a new mailTblMailType entity.
     *
     * @Route("/new", name="mailtblmailtype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mailTblMailType = new Mailtblmailtype();
        $form = $this->createForm('Orca\MailBundle\Form\MailTblMailTypeType', $mailTblMailType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailTblMailType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Mail type a été ajouté avec succès !');

            return $this->redirectToRoute('mailtblmailtype_index');
        }

        return $this->render('OrcaMailBundle:mailtblmailtype:new.html.twig', array(
            'mailTblMailType' => $mailTblMailType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mailTblMailType entity.
     *
     * @Route("/{id}", name="mailtblmailtype_show")
     * @Method("GET")
     */
    public function showAction(MailTblMailType $mailTblMailType)
    {
        $deleteForm = $this->createDeleteForm($mailTblMailType);

        return $this->render('OrcaMailBundle:mailtblmailtype:show.html.twig', array(
            'mailTblMailType' => $mailTblMailType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mailTblMailType entity.
     *
     * @Route("/{id}/edit", name="mailtblmailtype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MailTblMailType $mailTblMailType)
    {
        $deleteForm = $this->createDeleteForm($mailTblMailType);
        $editForm = $this->createForm('Orca\MailBundle\Form\MailTblMailTypeType', $mailTblMailType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'Mail type a été modifié avec succès !');

            return $this->redirectToRoute('mailtblmailtype_edit', array('id' => $mailTblMailType->getId()));
        }

        return $this->render('OrcaMailBundle:mailtblmailtype:edit.html.twig', array(
            'mailTblMailType' => $mailTblMailType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mailTblMailType entity.
     *
     * @Route("/deleted/{id}", name="mailtblmailtype_delete")
     */
    public function deleteAction(Request $request, MailTblMailType $mailTblMailType)
    {
        $form = $this->createDeleteForm($mailTblMailType);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($mailTblMailType->getMailTypeActif()){
            $this->get('session')->getFlashBag()->add('error', 'Impossible de supprimer, veuillez d\'abord désactiver le mail type et réessayer !');
        
            return $this->redirectToRoute('mailtblmailtype_index');
        }
        $em->remove($mailTblMailType);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Mail type a été supprimé avec succès !');
    
        return $this->redirectToRoute('mailtblmailtype_index');
    }

    /**
     * Creates a form to delete a mailTblMailType entity.
     *
     * @param MailTblMailType $mailTblMailType The mailTblMailType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MailTblMailType $mailTblMailType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mailtblmailtype_delete', array('id' => $mailTblMailType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
