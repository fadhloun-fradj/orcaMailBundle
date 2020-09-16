<?php
namespace Orca\MailBundle\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class SendMailCommand extends Command
{
    protected static $defaultName = 'app:SendMail';

    public function __construct()
    {
        parent::__construct();
    }
    protected function configure(){
        $this->setDescription('Envoi mail')
            ->setHelp('This command allow you to send mail')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit','-1');
        ini_set('max_execution_time','360000000000');
        $output->writeln('Debut '.date('Y-m-d H:i:s'));
        try{
//            $em = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getEntityManager();
            $mailer = new \Swift_Mailer(new \Swift_SmtpTransport());
            $this->getApplication()->getKernel()->getContainer()->get('app.mail_service')->traiteMail();
//            $output->writeln($c);
            $output->writeln('Fin '.date('Y-m-d H:i:s'));
        }
        catch(\Exception $e){
            $output->writeln($e->getMessage());
        }
    }
}