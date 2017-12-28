<?php
namespace Orca\MailBundle\Service;


use Doctrine\ORM\EntityManager;
use Orca\MailBundle\Entity\MailTblRegle;
use Orca\MailBundle\Entity\MailTblVue;

class RegleService
{
    private $em;


    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getVueDatas(MailTblVue $vue){
        $sql = $vue->getVueSqlRaw();
        $conn =  $this->em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function executePostTraiment(MailTblVue $vue){
        $conn =  $this->em->getConnection();
        $res = array();
        $sqls = explode(';',$vue->getVuePostSqlRaw());
        foreach($sqls as $sql){
            $stmt = $conn->prepare($sql);
            $res[] = $stmt->execute();
        }

        return $res;
    }

}