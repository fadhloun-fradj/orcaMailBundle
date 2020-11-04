<?php

namespace Orca\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailTblRegle
 *
 * @ORM\Table(name="mail_tbl_regle")
 * @ORM\Entity(repositoryClass="Orca\MailBundle\Repository\MailTblRegleRepository")
 */
class MailTblRegle
{
    /**
     * @var int
     *
     * @ORM\Column(name="regle_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="regle_lib", type="string", length=64, nullable=false)
     */
    private $regleLib;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="regle_heure", type="time", nullable=false, options={"default":"00:00:00"})
     */
    private $regleHeure;

    /**
     * @var bool
     *
     * @ORM\Column(name="regle_actif", type="boolean", nullable=false, options={"default": 0})
     */
    private $regleActif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="regle_date_envoi", type="datetime", nullable=false, options={"default": "2009-01-01 00:00:00"})
     */
    private $regleDateEnvoi;

    /**
     * @var bool
     *
     * @ORM\Column(name="regle_renvoi", type="boolean",nullable=false, options={"default": 0})
     */
    private $regleRenvoi;

    /**
     * @var \Orca\MailBundle\Entity\MailTblRegleFrequence
     *
     * @ORM\ManyToOne(targetEntity="Orca\MailBundle\Entity\MailTblRegleFrequence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="regle_frequence_id", referencedColumnName="regle_frequence_id",nullable=false)
     * })
     */
    private $regleFrequence;

    /**
     * @var \Orca\MailBundle\Entity\MailTblVue
     *
     * @ORM\ManyToOne(targetEntity="Orca\MailBundle\Entity\MailTblVue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vue_id", referencedColumnName="vue_id",nullable=false)
     * })
     */
    private $vue;

    /**
     * @var \Orca\MailBundle\Entity\MailTblMailType
     *
     * @ORM\ManyToOne(targetEntity="Orca\MailBundle\Entity\MailTblMailType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mail_type_id", referencedColumnName="mail_type_id",nullable=false)
     * })
     */
    private $mailType;

    public function __toString(){
        return $this->getRegleLib();
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
     * Set regleLib
     *
     * @param string $regleLib
     *
     * @return MailTblRegle
     */
    public function setRegleLib($regleLib)
    {
        $this->regleLib = $regleLib;

        return $this;
    }

    /**
     * Get regleLib
     *
     * @return string
     */
    public function getRegleLib()
    {
        return $this->regleLib;
    }

    /**
     * Set regleHeure
     *
     * @param \DateTime $regleHeure
     *
     * @return MailTblRegle
     */
    public function setRegleHeure($regleHeure)
    {
        $this->regleHeure = $regleHeure;

        return $this;
    }

    /**
     * Get regleHeure
     *
     * @return \DateTime
     */
    public function getRegleHeure()
    {
        return $this->regleHeure;
    }

    /**
     * Set regleActif
     *
     * @param boolean $regleActif
     *
     * @return MailTblRegle
     */
    public function setRegleActif($regleActif)
    {
        $this->regleActif = $regleActif;

        return $this;
    }

    /**
     * Get regleActif
     *
     * @return bool
     */
    public function getRegleActif()
    {
        return $this->regleActif;
    }

    /**
     * Set regleDateEnvoi
     *
     * @param \DateTime $regleDateEnvoi
     *
     * @return MailTblRegle
     */
    public function setRegleDateEnvoi($regleDateEnvoi)
    {
        $this->regleDateEnvoi = $regleDateEnvoi;

        return $this;
    }

    /**
     * Get regleDateEnvoi
     *
     * @return \DateTime
     */
    public function getRegleDateEnvoi()
    {
        return $this->regleDateEnvoi;
    }

    /**
     * Set regleRenvoi
     *
     * @param boolean $regleRenvoi
     *
     * @return MailTblRegle
     */
    public function setRegleRenvoi($regleRenvoi)
    {
        $this->regleRenvoi = $regleRenvoi;

        return $this;
    }

    /**
     * Get regleRenvoi
     *
     * @return bool
     */
    public function getRegleRenvoi()
    {
        return $this->regleRenvoi;
    }

    /**
     * @return MailTblRegleFrequence
     */
    public function getRegleFrequence()
    {
        return $this->regleFrequence;
    }

    /**
     * @param MailTblRegleFrequence $regleFrequence
     */
    public function setRegleFrequence($regleFrequence)
    {
        $this->regleFrequence = $regleFrequence;
    }

    /**
     * @return MailTblVue
     */
    public function getVue()
    {
        return $this->vue;
    }

    /**
     * @param MailTblVue $vue
     */
    public function setVue($vue)
    {
        $this->vue = $vue;
    }

    /**
     * @return MailTblMailType
     */
    public function getMailType()
    {
        return $this->mailType;
    }

    /**
     * @param MailTblMailType $mailType
     */
    public function setMailType($mailType)
    {
        $this->mailType = $mailType;
    }

    public function aEnvoye(){
        $res = true;
        $dateTimeUpdated = $this->getRegleDateEnvoi();
        $dateInterval = \DateInterval::createFromDateString($this->getRegleFrequence()->getRegleFrequenceDelai());

        $dateNow = new \DateTime('now');
        $dateNow->sub($dateInterval);
        if($dateNow < $dateTimeUpdated){
            $res = false;
        }
        if($this->getRegleHeure()){
            if($this->getRegleHeure()->format('Hi')>date('Hi')){
                $res = false;
            }
        }
//        var_dump($this->getRegleHeure()->format('Hi'));die;
        return $res;
    }
}

