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
}
