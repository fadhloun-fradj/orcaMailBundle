<?php

namespace Orca\MailBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MailTblVueAdminController extends CRUDController
{
    public function showResultAction($id){
        $object = $this->admin->getSubject();

        if(!$object){
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $em = $this->getDoctrine()->getManager();
		$conn =  $em->getConnection();
		$sql = $object->getVueSqlRaw();
		$stmt = $conn->prepare($sql);
		$stmt->execute();
        $result = $stmt->fetchAll()
                    ;
//var_dump($result);die;
        return new Response($this->renderView('OrcaMailBundle:CRUD:show_result.html.twig',array('sql'=>$sql,'result'=>$result)));
    }
}
