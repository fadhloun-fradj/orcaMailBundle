<?php

namespace Orca\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailTblMailType
 *
 * @ORM\Table(name="mail_tbl_mail_type")
 * @ORM\Entity(repositoryClass="Orca\MailBundle\Repository\MailTblMailTypeRepository")
 */
class MailTblMailType
{
    /**
     * @var int
     *
     * @ORM\Column(name="mail_type_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_type_lib", type="string", length=64)
     */
    private $mailTypeLib;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_type_objet", type="string", length=255)
     */
    private $mailTypeObjet;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_type_expediteur", type="string", length=64)
     */
    private $mailTypeExpediteur;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_type_cc", type="string", length=512, nullable=true)
     */
    private $mailTypeCc;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_type_bcc", type="string", length=5212, nullable=true)
     */
    private $mailTypeBcc;

    /**
     * @var bool
     *
     * @ORM\Column(name="mail_type_actif", type="boolean")
     */
    private $mailTypeActif;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_type_body", type="string", length=255)
     */
    private $mailTypeBody;

    private $_bodyTags = null;
    private $_objetTags = null;
    private $_ccTags = null;

    public function __toString(){
        return $this->getMailTypeLib();
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
     * Set mailTypeLib
     *
     * @param string $mailTypeLib
     *
     * @return MailTblMailType
     */
    public function setMailTypeLib($mailTypeLib)
    {
        $this->mailTypeLib = $mailTypeLib;

        return $this;
    }

    /**
     * Get mailTypeLib
     *
     * @return string
     */
    public function getMailTypeLib()
    {
        return $this->mailTypeLib;
    }

    /**
     * Set mailTypeObjet
     *
     * @param string $mailTypeObjet
     *
     * @return MailTblMailType
     */
    public function setMailTypeObjet($mailTypeObjet)
    {
        $this->mailTypeObjet = $mailTypeObjet;

        return $this;
    }

    /**
     * Get mailTypeObjet
     *
     * @return string
     */
    public function getMailTypeObjet()
    {
        return $this->mailTypeObjet;
    }

    /**
     * Set mailTypeExpediteur
     *
     * @param string $mailTypeExpediteur
     *
     * @return MailTblMailType
     */
    public function setMailTypeExpediteur($mailTypeExpediteur)
    {
        $this->mailTypeExpediteur = $mailTypeExpediteur;

        return $this;
    }

    /**
     * Get mailTypeExpediteur
     *
     * @return string
     */
    public function getMailTypeExpediteur()
    {
        return $this->mailTypeExpediteur;
    }

    /**
     * Set mailTypeCc
     *
     * @param string $mailTypeCc
     *
     * @return MailTblMailType
     */
    public function setMailTypeCc($mailTypeCc)
    {
        $this->mailTypeCc = $mailTypeCc;

        return $this;
    }

    /**
     * Get mailTypeCc
     *
     * @return string
     */
    public function getMailTypeCc()
    {
        return $this->mailTypeCc;
    }

    /**
     * Set mailTypeBcc
     *
     * @param string $mailTypeBcc
     *
     * @return MailTblMailType
     */
    public function setMailTypeBcc($mailTypeBcc)
    {
        $this->mailTypeBcc = $mailTypeBcc;

        return $this;
    }

    /**
     * Get mailTypeBcc
     *
     * @return string
     */
    public function getMailTypeBcc()
    {
        return $this->mailTypeBcc;
    }

    /**
     * Set mailTypeActif
     *
     * @param boolean $mailTypeActif
     *
     * @return MailTblMailType
     */
    public function setMailTypeActif($mailTypeActif)
    {
        $this->mailTypeActif = $mailTypeActif;

        return $this;
    }

    /**
     * Get mailTypeActif
     *
     * @return bool
     */
    public function getMailTypeActif()
    {
        return $this->mailTypeActif;
    }

    /**
     * Set mailTypeBody
     *
     * @param string $mailTypeBody
     *
     * @return MailTblMailType
     */
    public function setMailTypeBody($mailTypeBody)
    {
        $this->mailTypeBody = $mailTypeBody;

        return $this;
    }

    /**
     * Get mailTypeBody
     *
     * @return string
     */
    public function getMailTypeBody()
    {
        return $this->mailTypeBody;
    }

    public function getCcTags()
    {
        if($this->_ccTags === null)
        {
            preg_match_all("#{([^}]*)}#", $this->getMailTypeCc(), $this->_ccTags);
        }
        return $this->_ccTags;
    }

    public function getObjetTags()
    {
        if($this->_objetTags === null)
        {
            preg_match_all("#{([^}]*)}#", $this->getMailTypeObjet(), $this->_objetTags);
        }
        return $this->_objetTags;
    }

    public function getBodyTags()
    {
        if($this->_bodyTags === null)
        {
            $matches = null;
            preg_match_all("#{([^}]*)}#", $this->getMailTypeBody(), $this->_bodyTags);
        }
        return $this->_bodyTags;
    }
}

