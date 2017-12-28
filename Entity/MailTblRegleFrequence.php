<?php

namespace Orca\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailTblRegleFrequence
 *
 * @ORM\Table(name="mail_tbl_regle_frequence")
 * @ORM\Entity(repositoryClass="Orca\MailBundle\Repository\MailTblRegleFrequenceRepository")
 */
class MailTblRegleFrequence
{
    /**
     * @var int
     *
     * @ORM\Column(name="regle_frequence_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="regle_frequence_lib", type="string", length=32)
     */
    private $regleFrequenceLib;

    /**
     * @var string
     *
     * @ORM\Column(name="regle_frequence_delai", type="string", length=64)
     */
    private $regleFrequenceDelai;

    public function __toString(){
        return $this->getRegleFrequenceLib();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set regleFrequenceLin
     *
     * @param string $regleFrequenceLib
     *
     * @return MailTblRegleFrequence
     */
    public function setRegleFrequenceLib($regleFrequenceLib)
    {
        $this->regleFrequenceLib = $regleFrequenceLib;

        return $this;
    }

    /**
     * Get regleFrequenceLib
     *
     * @return string
     */
    public function getRegleFrequenceLib()
    {
        return $this->regleFrequenceLib;
    }

    /**
     * Set regleFrequenceDelai
     *
     * @param string $regleFrequenceDelai
     *
     * @return MailTblRegleFrequence
     */
    public function setRegleFrequenceDelai($regleFrequenceDelai)
    {
        $this->regleFrequenceDelai = $regleFrequenceDelai;

        return $this;
    }

    /**
     * Get regleFrequenceDelai
     *
     * @return string
     */
    public function getRegleFrequenceDelai()
    {
        return $this->regleFrequenceDelai;
    }
}

