<?php
namespace Orca\MailBundle\Service;


use Doctrine\ORM\EntityManager;
use Orca\MailBundle\Entity\MailTblMail;
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
        if(file_exists($lockFileName))
            unlink($lockFileName);
        if(!file_exists($lockFileName) || (filemtime($lockFileName) < strtotime('-2 hours')))
        {
            file_put_contents($lockFileName, date('Y-m-d H:i:s').' en cours');
            $regles = $this->em->getRepository('OrcaMailBundle:MailTblRegle')->findBy(array('regleActif'=>true));
//            var_dump('REGLE COUNT : '. count($regles));
//            var_dump('PARAMS MAIL_NBR : '. $this->mail_nbr);
            foreach($regles as $regle) /** @var MailTblRegle $regle */
            {
//                var_dump('REGLE : '.$regle->getRegleLib());
                if($regle->aEnvoye()){
                    $vue = $regle->getVue();
                    $vueDatas = $this->regleService->getVueDatas($vue);
//                    var_dump('DATA : '. count($vueDatas));

                    foreach($vueDatas as $vueData){
//                            var_dump('SENDMAIL=>COUNT : '.$count);
                            if($count > $this->mail_nbr){
//                                var_dump('$count > $this->mail_nbr : TRUE');
                                file_put_contents($lockFileName, 'Le plugin de mail a été arrêté, si vous voulez continuer l\'envoie des emails merci de supprimer ce fichier');
                                $ok = false;
                                break;
                            }
                            try{
                                if(filter_var($vueData['destinataire'],FILTER_VALIDATE_EMAIL)) {
                                    $this->tblMailService->traiteMail($this->mailer, $regle, $vueData, false, '');
                                    $mail = $this->em->getRepository('OrcaMailBundle:MailTblMail')->findOneBy(array(
                                        'mailRegle'=>$regle,
                                        'id'=>$vueData['user_id']
                                    ));
                                    if($mail instanceof MailTblMail && $mail->getCreatedAt()->format('Y-m-d')==date("Y-m-d")){
                                        $count++;
                                    }
                                }
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
                        $this->createNewEntityManager();
                        $this->em->flush($regle);
                        //$this->em->close();

                   // }
                }

                if($count > $this->mail_nbr){
                    file_put_contents($lockFileName, 'Le plugin de mail a été arrêté, si vous voulez continuer l\'envoie des emails merci de supprimer ce fichier');
                    break;
                }
            }
            if($ok)
                unlink($lockFileName);
            file_put_contents($lockFileName, date('Y-m-d H:i:s').' FIN');
        }
    }

    protected function createNewEntityManager() {

	    $this->em = !$this->em->isOpen() ? $this->em->create(
	        $this->em->getConnection(),
	        $this->em->getConfiguration(),
	        $this->em->getEventManager()
	    ) : $this->em;
	}

}
