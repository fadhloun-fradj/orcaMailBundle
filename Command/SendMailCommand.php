<?php
namespace Orca\MailBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMailCommand extends Command
{
    protected function configure(){
        $this->setName('app:sendmail')
            ->setDescription('Envoi mail')
            ->setHelp('This command allow you to send mail')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Debut '.date('Y-m-d H:i:s'));

        try{
//            $em = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getEntityManager();
            $mailer = new \Swift_Mailer(new \Swift_SmtpTransport());
            $this->getApplication()->getKernel()->getContainer()->get('app.mail_service')->traiteMail();

//            $output->writeln($c);
            $output->writeln('Fin '.date('Y-m-d H:i:s'));
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','3600');
        }
        catch(\Exception $e){
            $output->writeln($e->getMessage());
        }
    }
}