<?php
namespace Orca\MailBundle\Service;


use Doctrine\ORM\EntityManager;
use Orca\MailBundle\Entity\MailTblMail;
use Orca\MailBundle\Entity\MailTblMailType;
use Orca\MailBundle\Entity\MailTblRegle;
use Orca\MailBundle\Entity\MailTblVue;
use Orca\MailBundle\Utils\Constants;

class TblMailService
{
    private $em;
    private $dir;
    private $is_mail_enabled;
    private $is_mail_destinataire_enabled;
    private $mail_destinataire;
    private $mail_expediteur;
    private $projet;


    public function __construct(EntityManager $em,$dir,ContainerInterface $container)
    {
        $this->em = $em;
        $this->dir = realpath($dir.'/../web');
        $this->is_mail_enabled = $container->getParameter('is_mail_enabled');
        $this->is_mail_destinataire_enabled = $container->getParameter('is_mail_destinataire_enabled');
        $this->mail_destinataire = $container->getParameter('mail_destinataire') ? $container->getParameter('mail_destinataire') : Constants::MAIL_ADMIN;
        $this->mail_expediteur = $container->getParameter('mail_expediteur')  ? $container->getParameter('mail_expediteur') : Constants::MAIL_ADMIN;
        $this->projet = $container->getParameter('projet') ? $container->getParameter('projet') : Constants::PROJET;
    }

    public function traiteMail(\Swift_Mailer $mailer,MailTblRegle $regle, $vueData,$exception = false,$msgError = ''){
        if(!isset($vueData['user_id']))
        {
            throw new \Exception('la vue (r�gle '.$regle->getId().') doit poss�der un champs user_id.');
        }
        if(!isset($vueData['destinataire']))
        {
            throw new \Exception('la vue doit poss�der un champs destinataire.');
        }
        $mail = $this->em->getRepository('OrcaMailBundle:MailTblMail')->findOneBy(array(
            'mailRegle'=>$regle,
            'id'=>$exception?$vueData['user_id'].'_Exception':$vueData['user_id']
        ));
        if(!$mail || $regle->getRegleRenvoi()){

            if(!$mail)
                $mail = new MailTblMail();
            $this->mailTraiteMail($mailer,$mail,$regle,$vueData,$exception,$msgError);
        }
    }

    public function mailTraiteMail(\Swift_Mailer $mailer,MailTblMail $mail,MailTblRegle $regle,$vueData,$exception = false,$msgError = ''){
        $this->initMail($mail, $regle, $vueData,$exception);
        if(!$exception)
            $this->sendMail($mailer,$mail,$vueData);
        else{

            $msg = $msgError.' regle : '.$regle->getId().' '.$regle->getRegleLib().', vueData : ';
            foreach($vueData as $champs => $data)
            {
                $msg .= $champs.' : '.$data.' ';
            }
            $message = new \Swift_Message();
            if (isset($vueData['expediteur']))
            {
                $message->setFrom($vueData['expediteur']);
            }
            else
            {
                $message->setFrom($mail->getMailExpediteur());
            }
            $message->setBody($msg,'text/html');
            $message->setTo($this->mail_expediteur);
            $message->setSubject('Exception erreur envoi mail ['.$this->projet.']');

            if($this->is_mail_enabled)
                $mailer->send($message);
        }
    }
    public function initMail(MailTblMail $mail,MailTblRegle $regle, $vueData,$exception = false,$save = true){
        $type = $regle->getMailType();
        if (!isset($vueData['user_id']))
        {
            throw new \Exception('la vue doit poss�der un champs user_id.');
        }
        if (!isset($vueData['destinataire']))
        {
            throw new \Exception('la vue doit poss�der un champs destinataire.');
        }
        if($exception)
            $mail->setId($vueData['user_id'].'_Exception');
        else
            $mail->setId($vueData['user_id']);
        $mail->setMailRegle($regle);
        $mail->setMailVueData(json_encode($vueData));
        $mail->setMailType($type);
        $mail->setMailExpediteur($type->getMailTypeExpediteur() ? $type->getMailTypeExpediteur() : $this->mail_expediteur);

        $objetTags = $type->getCcTags();

        $replaceObjetTags = array();

        foreach ($objetTags[1] as $tag)
        {
            if (!array_key_exists($tag, $vueData))
            {
                throw new \Exception('tag ' . $tag . ' non disponible dans la vue.');
            }
            $replaceObjetTags[] = $vueData[$tag];
        }

        $cc = $type->getMailTypeCc();
        $cc = str_replace($objetTags[0],$replaceObjetTags,$cc);
        $mail->setMailCc($cc);

        $mail->setMailBcc($type->getMailTypeBcc());

        if($this->is_mail_destinataire_enabled) // Mail Statique
            $mail->setMailDestinataire($this->mail_destinataire);
        else // Mail dynamique
            $mail->setMailDestinataire($vueData['destinataire']);
        // Mail dynamique
//        $mail->setMailDestinataire($vueData['destinataire']);
        // Mail Statique
//        $mail->setMailDestinataire('admin.beneteau@orcaformation.fr');

        $objetTags = $type->getObjetTags();

        $replaceObjetTags = array();
        //verif que tous les tags sont disponibles
        foreach ($objetTags[1] as $tag)
        {
            if (!array_key_exists($tag, $vueData))
            {
                throw new \Exception('tag ' . $tag . ' non disponible dans la vue.');
            }
            $replaceObjetTags[] = $vueData[$tag];
        }

        //remplacement du body
        $objet = $type->getMailTypeObjet();
        $objet = str_replace($objetTags[0], $replaceObjetTags, $objet);
        $mail->setMailObject($objet);

        //remplacement body
        $bodyTags = $type->getBodyTags();

        $replaceBodyTags = array();
        //verif que tous les tags sont disponibles
        foreach ($bodyTags[1] as $tag)
        {
            if (!array_key_exists($tag, $vueData))
            {
                throw new \Exception('tag ' . $tag . ' non disponible dans la vue.');
            }
            $replaceBodyTags[] = $vueData[$tag];
        }

        //remplacement du body
        $body = $type->getMailTypeBody();
        $body = str_replace($bodyTags[0], $replaceBodyTags, $body);
        $mail->setMailBody($body);


        if($save){
	        $this->createNewEntityManager();
	        //var_dump($em);		
            $this->em->persist($mail);
            $this->em->flush();
            //$this->em->close();
        }

    }

    public function sendMail(\Swift_Mailer $mailer,MailTblMail $mail,$vueData){

        $message = new \Swift_Message();
        if (isset($vueData['expediteur']))
        {
            $message->setFrom($vueData['expediteur']);
        }
        else
        {
            $message->setFrom($mail->getMailExpediteur());
        }
        $message->addTo($mail->getMailDestinataire());

        if ($mail->getMailCc())
        {
            foreach(explode(';', $mail->getMailCc()) as $cc)
            {
                $message->addCc($cc);
            }
        }
        if ($mail->getMailBcc())
        {
            foreach(explode(';', $mail->getMailBcc()) as $bcc)
            {
                $message->addBcc($bcc);
            }
        }
        $message->setSubject($mail->getMailObject());
        $message->setBody($mail->getMailBody(), 'text/html');

        for($nbrPj=1;$nbrPj<=10;$nbrPj++)
        {
            $pj_name = $nbrPj == 1?'pj':'pj'.$nbrPj;

            if (isset($vueData[$pj_name]))
            {
                $pj = $this->dir . $vueData[$pj_name];
                if (file_exists($pj))
                {
                    $attachement = \Swift_Attachment::fromPath($pj);
                    $message->attach($attachement);
                }
            }
        }

        if($this->is_mail_enabled)
            $mailer->send($message);
        $mail->setUpdatedAt(new \DateTime('now'));
        $this->createNewEntityManager();
        $this->em->flush($mail);
        //$this->em->close();	

    }

    public function traiteMailException(\Swift_Mailer $mailer,\Swift_Message $message,MailTblRegle $regle, $vueData){

        $mail = $this->em->getRepository('OrcaMailBundle:MailTblMail')->findOneBy(array(
            'mailRegle'=>$regle,
            'id'=>$vueData['user_id']
        ));
        if(!$mail || $regle->getRegleRenvoi()){

            if(!$mail)
                $mail = new MailTblMail();
            $this->mailTraiteMail($mailer,$mail,$regle,$vueData,true);
        }

        if($this->is_mail_enabled)
            $mailer->send($message);
    }
    protected function createNewEntityManager() {

        $this->em = !$this->em->isOpen() ? $this->em->create(
            $this->em->getConnection(),
            $this->em->getConfiguration(),
            $this->em->getEventManager()
        ) : $this->em;
    }
}
