<?php

namespace Orca\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OrcaMailBundle:Default:index.html.twig');
    }
}
