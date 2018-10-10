<?php

namespace Orca\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * DefaultController controller.
 *
 * @Route("traiteMail")
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OrcaMailBundle:Default:index.html.twig');
    }


    /**
     * for Testing PlugIn de mail
     *
     * @Route("/testing", name="testing_traiteMail")
     * @Method({"GET", "POST"})
     */
    function traiteMailAction(){
        ini_set('memory_limit','-1');
        ini_set('max_execution_time','0');
        set_time_limit(0);
        echo 'Debut '.date('Y-m-d H:i:s');
        try{
//            $em = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getEntityManager();
            $mailer = new \Swift_Mailer(new \Swift_SmtpTransport());
            $this->get('app.mail_service')->traiteMail();

//            $output->writeln($c);
            echo 'Fin '.date('Y-m-d H:i:s');

        }
        catch(\Exception $e){
            echo $e->getMessage().' '.$e->getTraceAsString();
        }
    }


    /**
     * for Testing PlugIn de mail
     *
     * @Route("/mail", name="testing_sendmail")
     * @Method({"GET", "POST"})
     */
    public function sendmail(Request $request){
        $mailer = new \Swift_Mailer((new \Swift_SmtpTransport($this->getParameter('mailer_host'),25))->setUsername($this->getParameter('mailer_user'))->setPassword($this->getParameter('mailer_password')));
        $mail = $request->get('mail');
        if(!empty($mail)) {
            @mail($mail, "My subject", "ddddddd");
            $message = (new \Swift_Message('Hello Email2'))
                ->setFrom($mail)
                ->setTo($mail)
                ->setBody(';,qsdjkkqsdqslqsdfmsdqmmfsdqfqdksf',
                    'text/plain'
                )/*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
            ;

            $mailer->send($message);
        }
    }
}
