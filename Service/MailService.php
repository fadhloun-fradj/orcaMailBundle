<?php
namespace Orca\MailBundle\Service;


use Doctrine\ORM\EntityManager;
use Orca\MailBundle\Entity\MailTblMail;
use Orca\MailBundle\Entity\MailTblRegle;
use Psr\Container\ContainerInterface;

class MailService
{
    private $em;
    private $regleService;
    private $tblMailService;
    private $mailer;
    private $dir;
    private $mail_nbr;

    public function __construct(EntityManager $em,$regleService,$tblMailService,\Swift_Mailer $mailer,$dir,ContainerInterface $container)
    {
        $this->em = $em;
        $this->regleService = $regleService;
        $this->tblMailService = $tblMailService;
        $this->mailer = $mailer;
        $this->dir = realpath($dir.'/../public');
        $this->mail_nbr = $container->getParameter('mail_nbr');
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
            foreach($regles as $regle) /** @var MailTblRegle $regle */
            {
                if($regle->aEnvoye()){
                    $vue = $regle->getVue();
                    $vueDatas = $this->regleService->getVueDatas($vue);

                    foreach($vueDatas as $vueData){
                            if($count > $this->mail_nbr){
                                file_put_contents($lockFileName, 'Le plugin de mail a été arrêté, si vous voulez continuer l\'envoie des emails merci de supprimer ce fichier');
                                $ok = false;
                                break;
                            }
                            try{
                                if(filter_var($vueData['destinataire'],FILTER_VALIDATE_EMAIL)) {
                                    $this->tblMailService->traiteMail($regle, $vueData, false, '');
                                    $mail = $this->em->getRepository('OrcaMailBundle:MailTblMail')->findOneBy(array(
                                        'mailRegle'=>$regle,
                                        'user_id'=>$vueData['user_id']
                                    ));
                                
                                    
                                    if($mail instanceof MailTblMail && $mail->getCreatedAt()->format('Y-m-d')==date("Y-m-d")){
                                        $count++;
                                    }
                                    
                                }
                                else{
                                    $this->tblMailService->traiteMail($regle,$vueData,true,'Adress mail invalid');
                                }
                            }
                            catch(\Exception $e){
                                $this->tblMailService->traiteMail($regle,$vueData,true,$e->getMessage());
                            }


                        }
                        if($vue->getVuePostSqlRaw()){
                            $this->regleService->executePostTraiment($vue);
                        }
                        $regle->setRegleDateEnvoi(new \DateTime('now'));
                        $this->createNewEntityManager();
                        $this->em->flush($regle);
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
