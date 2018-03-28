<?php
namespace Orca\MailBundle\Service;


use Doctrine\ORM\EntityManager;
use Orca\MailBundle\Entity\MailTblRegle;

class MailService
{
    private $em;
    private $regleService;
    private $tblMailService;
    private $mailer;
    private $dir;
    private $mail_nbr;
    private $is_mail_enabled;


    public function __construct(EntityManager $em,$regleService,$tblMailService,\Swift_Mailer $mailer,$dir,$mail_nbr)
    {
        $this->em = $em;
        $this->regleService = $regleService;
        $this->tblMailService = $tblMailService;
        $this->mailer = $mailer;
        $this->dir = realpath($dir.'/../web');
        $this->mail_nbr = $mail_nbr;
    }

    public function traiteMail(){
        $lockFileName = $this->dir.'/lock_mail.sm';
        $ok = true;
        $ids = '';
        $count = 0;
        if(!file_exists($lockFileName) || (filemtime($lockFileName) < strtotime('-2 hours')))
        {
            file_put_contents($lockFileName, 'en cours');
            $regles = $this->em->getRepository('OrcaMailBundle:MailTblRegle')->findBy(array('regleActif'=>true));
            foreach($regles as $regle) /** @var MailTblRegle $regle */
            {
                if($regle->aEnvoye()){
                    $vue = $regle->getVue();
                    $vueDatas = $this->regleService->getVueDatas($vue);
                    foreach($vueDatas as $vueData){
                        try{
                            if(filter_var($vueData['destinataire'],FILTER_VALIDATE_EMAIL))
                                $exception = false;
                            else{
                                $exception = true;
                            }
                        }
                        catch(\Exception $e){
                            $exception = true;
                        }
                        $mail = $this->em->getRepository('OrcaMailBundle:MailTblMail')->findOneBy(array(
                            'mailRegle'=>$regle,
                            'id'=>$exception?$vueData['user_id'].'_Exception':$vueData['user_id']
                        ));
                        if(!$mail || $regle->getRegleRenvoi()){
                            $count++;
                        }
                    }
                    if($count > $this->mail_nbr){
                        file_put_contents($lockFileName, 'Le plugin de mail a été arrêté, si vous voulez continuer l\'envoie des emails merci de supprimer ce fichier');
                        $ok = false;
                    }
                    else{
                        foreach($vueDatas as $vueData){
                            try{
                                if(filter_var($vueData['destinataire'],FILTER_VALIDATE_EMAIL))
                                    $this->tblMailService->traiteMail($this->mailer,$regle,$vueData,false,'');
                                else{
                                    $this->tblMailService->traiteMail($this->mailer,$regle,$vueData,true,'Adress mail invalid');
                                }
                            }
                            catch(\Exception $e){
                                $this->tblMailService->traiteMail($this->mailer,$regle,$vueData,true,$e->getMessage());
                            }

                        }
                        if($vue->getVuePostSqlRaw()){
                            $this->regleService->executePostTraiment($vue);
                        }
                        $regle->setRegleDateEnvoi(new \DateTime('now'));
                        $this->em->flush($regle);
                    }
                }
            }
            if($ok)
                unlink($lockFileName);
        }

    }

}