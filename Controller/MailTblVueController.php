<?php

namespace Orca\MailBundle\Controller;

use Orca\MailBundle\Entity\MailTblVue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mailtblvue controller.
 *
 * @Route("MKZQWDTZHBBRGALA")
 */
class MailTblVueController extends Controller
{
    /**
     * @Route("/PKGHZUDEONITBMXD", name="getResultSQL")
     */
    public function getResultSqlAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $query = $request->get('sql');
        // $conn = $em->getConnection();
        // $statement = $conn->prepare($query);
        // $statement->execute();
        // $results = $statement->fetchAll();
        return $this->render('OrcaMailBundle:mailtblvue:result_query_sql.html.twig', array(
            'results' => [],
            'sql' => $query,
        ));
    }

    /**
     * Lists all mailTblVue entities.
     *
     * @Route("/SRRERVHHLDDPRXPN", name="mailtblvue_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mailTblVues = $em->getRepository('OrcaMailBundle:MailTblVue')->findAll();

        return $this->render('OrcaMailBundle:mailtblvue:index.html.twig', array(
            'mailTblVues' => $mailTblVues,
        ));
    }

    /**
     * Creates a new mailTblVue entity.
     *
     * @Route("/WDCSOLOFJRCGJUAB", name="mailtblvue_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mailTblVue = new Mailtblvue();
        $form = $this->createForm('Orca\MailBundle\Form\MailTblVueType', $mailTblVue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailTblVue);
            $em->flush();

            return $this->redirectToRoute('mailtblvue_show', array('id' => $mailTblVue->getId()));
        }

        return $this->render('OrcaMailBundle:mailtblvue:new.html.twig', array(
            'mailTblVue' => $mailTblVue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mailTblVue entity.
     *
     * @Route("/EAUYWZTDVLSUUWBM/{id}", name="mailtblvue_show")
     * @Method("GET")
     */
    public function showAction(MailTblVue $mailTblVue)
    {
        $deleteForm = $this->createDeleteForm($mailTblVue);

        return $this->render('OrcaMailBundle:mailtblvue:show.html.twig', array(
            'mailTblVue' => $mailTblVue,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mailTblVue entity.
     *
     * @Route("/NPJCGSIYMXUNJKEL/{id}/edit", name="mailtblvue_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MailTblVue $mailTblVue)
    {
        $deleteForm = $this->createDeleteForm($mailTblVue);
        $editForm = $this->createForm('Orca\MailBundle\Form\MailTblVueType', $mailTblVue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mailtblvue_edit', array('id' => $mailTblVue->getId()));
        }

        return $this->render('OrcaMailBundle:mailtblvue:edit.html.twig', array(
            'mailTblVue' => $mailTblVue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mailTblVue entity.
     *
     * @Route("/YSUAEMMVWWWOCLTY/{id}", name="mailtblvue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MailTblVue $mailTblVue)
    {
        $form = $this->createDeleteForm($mailTblVue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mailTblVue);
            $em->flush();
        }

        return $this->redirectToRoute('mailtblvue_index');
    }

    /**
     * Creates a form to delete a mailTblVue entity.
     *
     * @param MailTblVue $mailTblVue The mailTblVue entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MailTblVue $mailTblVue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mailtblvue_delete', array('id' => $mailTblVue->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
