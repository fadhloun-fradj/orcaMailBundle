<?php

namespace Orca\MailBundle\Controller;

use Orca\MailBundle\Entity\MailTblRegleFrequence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mailtblreglefrequence controller.
 *
 * @Route("mailtblreglefrequence")
 */
class MailTblRegleFrequenceController extends Controller
{
    /**
     * Lists all mailTblRegleFrequence entities.
     *
     * @Route("/", name="mailtblreglefrequence_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mailTblRegleFrequences = $em->getRepository('OrcaMailBundle:MailTblRegleFrequence')->findAll();

        return $this->render('OrcaMailBundle:mailtblreglefrequence:index.html.twig', array(
            'mailTblRegleFrequences' => $mailTblRegleFrequences,
        ));
    }

    /**
     * Creates a new mailTblRegleFrequence entity.
     *
     * @Route("/new", name="mailtblreglefrequence_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mailTblRegleFrequence = new Mailtblreglefrequence();
        $form = $this->createForm('Orca\MailBundle\Form\MailTblRegleFrequenceType', $mailTblRegleFrequence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailTblRegleFrequence);
            $em->flush();

            return $this->redirectToRoute('mailtblreglefrequence_show', array('id' => $mailTblRegleFrequence->getId()));
        }

        return $this->render('OrcaMailBundle:mailtblreglefrequence:new.html.twig', array(
            'mailTblRegleFrequence' => $mailTblRegleFrequence,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mailTblRegleFrequence entity.
     *
     * @Route("/{id}", name="mailtblreglefrequence_show")
     * @Method("GET")
     */
    public function showAction(MailTblRegleFrequence $mailTblRegleFrequence)
    {
        $deleteForm = $this->createDeleteForm($mailTblRegleFrequence);

        return $this->render('OrcaMailBundle:mailtblreglefrequence:show.html.twig', array(
            'mailTblRegleFrequence' => $mailTblRegleFrequence,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mailTblRegleFrequence entity.
     *
     * @Route("/{id}/edit", name="mailtblreglefrequence_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MailTblRegleFrequence $mailTblRegleFrequence)
    {
        $deleteForm = $this->createDeleteForm($mailTblRegleFrequence);
        $editForm = $this->createForm('Orca\MailBundle\Form\MailTblRegleFrequenceType', $mailTblRegleFrequence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mailtblreglefrequence_edit', array('id' => $mailTblRegleFrequence->getId()));
        }

        return $this->render('OrcaMailBundle:mailtblreglefrequence:edit.html.twig', array(
            'mailTblRegleFrequence' => $mailTblRegleFrequence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mailTblRegleFrequence entity.
     *
     * @Route("/{id}", name="mailtblreglefrequence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MailTblRegleFrequence $mailTblRegleFrequence)
    {
        $form = $this->createDeleteForm($mailTblRegleFrequence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mailTblRegleFrequence);
            $em->flush();
        }

        return $this->redirectToRoute('mailtblreglefrequence_index');
    }

    /**
     * Creates a form to delete a mailTblRegleFrequence entity.
     *
     * @param MailTblRegleFrequence $mailTblRegleFrequence The mailTblRegleFrequence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MailTblRegleFrequence $mailTblRegleFrequence)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mailtblreglefrequence_delete', array('id' => $mailTblRegleFrequence->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
