<?php
namespace Orca\MailBundle\Service;


use Doctrine\ORM\EntityManager;
use Exception;
use Orca\MailBundle\Entity\MailTblMail;
use Orca\MailBundle\Entity\MailTblMailType;
use Orca\MailBundle\Entity\MailTblRegle;
use Orca\MailBundle\Entity\MailTblVue;
use Orca\MailBundle\Form\MailTblVueType;
use Orca\MailBundle\Utils\Constants;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\TodoSniff;
use Psr\Container\ContainerInterface;
use Symfony\Component\VarDumper\VarDumper;
use Twig\Environment;
class TblMailService
{
    private $em;
    private $dir;
    private $is_mail_enabled;
    private $is_mail_destinataire_enabled;
    private $mail_destinataire;
    private $mail_expediteur;
    private $projet;
    private $save=true;
    private $templating;
    private $mailer;

    public function __construct(EntityManager $em,$dir,ContainerInterface $container,Environment $templating,\Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->dir = realpath($dir.'/../public');
        $this->is_mail_enabled = $container->getParameter('is_mail_enabled');
        $this->is_mail_destinataire_enabled = $container->getParameter('is_mail_destinataire_enabled');
        $this->is_mail_destinataire_enabled = $container->getParameter('is_mail_destinataire_enabled');
        $this->mail_destinataire = $container->getParameter('mail_destinataire') ? $container->getParameter('mail_destinataire') : Constants::MAIL_ADMIN;
        $this->mail_expediteur = $container->getParameter('mail_expediteur')  ? $container->getParameter('mail_expediteur') : Constants::MAIL_ADMIN;
        $this->projet = $container->getParameter('projet') ? $container->getParameter('projet') : Constants::PROJET;
        $this->templating = $templating;
        $this->mailer = $mailer;
       
    }

    public function traiteMail(MailTblRegle $regle, $vueData,$exception = false,$msgError = ''){

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
            'user_id'=>$exception?$vueData['user_id'].'_Exception':$vueData['user_id']
        ));

        if(!$mail || $regle->getRegleRenvoi()){

            if(!$mail)
                $mail = new MailTblMail();
            $this->mailTraiteMail($mail,$regle,$vueData,$exception,$msgError,false);
        }
    }

    public function mailTraiteMail(MailTblMail $mail,MailTblRegle $regle,$vueData,$exception = false,$msgError = ''){
        $this->initMail($mail, $regle, $vueData,$exception);
        if(!$exception)
            $this->sendMail($mail,$vueData);
            // $this->SendMailPrototype($mailer,$mail,$vueData,new MailTblMailType());
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
                $this->mailer->send($message);
        }
    }
    public function initMail(MailTblMail $mail,MailTblRegle $regle, $vueData,$exception = false){

        $type = $regle->getMailType();
        if (!isset($vueData['user_id'])){
            throw new \Exception('la vue doit poss�der un champs user_id.');
        }
        if (!isset($vueData['destinataire'])){
            throw new \Exception('la vue doit poss�der un champs destinataire.');
        }
        if($exception){
            $mail->setUserId($vueData['user_id'].'_Exception');
        }    
        else{
            $mail->setUserId($vueData['user_id']);
        }
        $mail->setMailRegle($regle);
        $mail->setMailVueData(json_encode($vueData));
        $mail->setMailType($type);
        $mail->setMailExpediteur($type->getMailTypeExpediteur() ? $type->getMailTypeExpediteur() : $this->mail_expediteur);

        $objetTags = $type->getCcTags();

        $replaceObjetTags = array();

        foreach ($objetTags[1] as $tag){

            if (!array_key_exists($tag, $vueData)){

                throw new \Exception('tag ' . $tag . ' non disponible dans la vue.');
            }
            $replaceObjetTags[] = $vueData[$tag];
        }
        $cc = $type->getMailTypeCc();
        $cc = str_replace($objetTags[0],$replaceObjetTags,$cc);
        $mail->setMailCc($cc);

        $mail->setMailBcc($type->getMailTypeBcc());
        
        if($this->is_mail_destinataire_enabled){ // Mail Statique
            $mail->setMailDestinataire($this->mail_destinataire);
        }
        else{// Mail dynamique
            $mail->setMailDestinataire($vueData['destinataire']);
        }

        //remplacement du body
        $objet = $type->getMailTypeObjet();
        $renderer_object = $this->templating->createTemplate($objet);
        $mail->setMailObject($this->templating->render($renderer_object,$vueData));

        //remplacement du body
        $body = $type->getMailTypeBody();
        $renderer = $this->templating->createTemplate($body);
        $mail->setMailBody($this->templating->render($renderer,$vueData)); 

        if($this->save){

	        $this->createNewEntityManager();	
            $this->em->persist($mail);
            $this->em->flush();
            //$this->em->close();
        }

    }

    public function sendMail(MailTblMail $mail,$vueData){

        $message = new \Swift_Message();
        if (isset($vueData['expediteur'])){

            $message->setFrom($vueData['expediteur']);
        }
        else{

            $message->setFrom($mail->getMailExpediteur());
        }
        $message->addTo($mail->getMailDestinataire());

        if ($mail->getMailCc()){

            foreach(explode(';', $mail->getMailCc()) as $cc){

                $message->addCc($cc);
            }
        }
        if ($mail->getMailBcc()){

            foreach(explode(';', $mail->getMailBcc()) as $bcc){

                $message->addBcc($bcc);
            }
        }
        $message->setSubject($mail->getMailObject());
        $message->setBody($mail->getMailBody(), 'text/html');

        for($nbrPj=1;$nbrPj<=10;$nbrPj++){

            $pj_name = $nbrPj == 1?'pj':'pj'.$nbrPj;

            if (isset($vueData[$pj_name])){

                $pj = $this->dir . $vueData[$pj_name];

                if (file_exists($pj)){

                    $attachement = \Swift_Attachment::fromPath($pj);
                    $message->attach($attachement);
                }
            }
        }

        if($this->is_mail_enabled){

            $this->mailer->send($message);
        }

        if($this->save){

        $mail->setUpdatedAt(new \DateTime('now'));
        $this->createNewEntityManager();
        $this->em->flush($mail);
        }
        //$this->em->close();	
        

    }

    public function traiteMailException(\Swift_Message $message,MailTblRegle $regle, $vueData){

        $mail = $this->em->getRepository('OrcaMailBundle:MailTblMail')->findOneBy(array(
            'mailRegle'=>$regle,
            'user_id'=>$vueData['user_id']
        ));
        if(!$mail || $regle->getRegleRenvoi()){

            if(!$mail)
                $mail = new MailTblMail();
            $this->mailTraiteMail($mail,$regle,$vueData,true);
        }

        if($this->is_mail_enabled)
            $this->mailer->send($message);
    }
    protected function createNewEntityManager() {

        $this->em = !$this->em->isOpen() ? $this->em->create(
            $this->em->getConnection(),
            $this->em->getConfiguration(),
            $this->em->getEventManager()
        ) : $this->em;
    }

    public function initValueData($vue_data){
        $vue_data=array_merge($vue_data,["user_id"=>"default".time()]);
        return $vue_data;
    }

    public function traiteMailStandalone(MailTblMailType $mail_type,$vue_data,$save=false){

        $this->save=$save;
        $vue_data = $this->initValueData($vue_data);
        $mail = new MailTblMail();
        $qb = $this->em->createQueryBuilder();
        $mail_regle =  $qb->select("r")
                    ->from("Orca\MailBundle\Entity\MailTblRegle",'r')
                    ->where('r.regleLib = :identifier')
                    ->setParameter('identifier',"Regle defaut")->getQuery()->getOneOrNullResult();  

        /** @var MailTblRegle $mail_regle */
        if(!$mail_regle){

            throw new Exception("Veuillez utiliser la regle dont le libelle est: Regle defaut");
        }

        $mail_regle->setMailType($mail_type);
        if($this->save){

            $this->traiteMail($mail_regle,$vue_data);
        }

        else{

        $this->mailTraiteMail($mail,$mail_regle,$vue_data);

        }
    }
    public function traiteMailTypeStandalone($mail_type_lib, $vue_data, $store)
    {
        if (!isset($vue_data["destinataire"])) {
            throw new Exception("Veuillez ajouter le destinataire au niveau du tableau");
        }

        $mail_type = new MailTblMailType();
        $qb = $this->em->createQueryBuilder();
        $mail_type = $qb->select("t")
                    ->from("Orca\MailBundle\Entity\MailTblMailType", 't')
                    ->where('t.mailTypeLib = :mail_type_lib')
                    ->setParameter('mail_type_lib', $mail_type_lib)
                    ->getQuery()
                    ->getOneOrNullResult();
         /** @var MailTblMailType $mail_type */
        if (!$mail_type) {
            throw new Exception("Le libelle du mailtype est introuvable");
        }

        $this->traiteMailStandalone($mail_type, $vue_data, $store);
    }
}
