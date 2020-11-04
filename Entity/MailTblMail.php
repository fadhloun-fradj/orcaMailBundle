<?php

namespace Orca\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailTblMail
 *
 * @ORM\Table(name="mail_tbl_mail")
 * @ORM\Entity(repositoryClass="Orca\MailBundle\Repository\MailTblMailRepository")
 */
class MailTblMail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="user_id", type="string",length=64,nullable=true)
     */
    private $user_id;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_object", type="string", length=255)
     */
    private $mailObject;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_expediteur", type="string", length=64, nullable=true)
     */
    private $mailExpediteur;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_destinataire", type="string", length=512)
     */
    private $mailDestinataire;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_cc", type="string", length=512, nullable=true)
     */
    private $mailCc;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_bcc", type="string", length=512, nullable=true)
     */
    private $mailBcc;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_body", type="text", nullable=true)
     */
    private $mailBody;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_vue_data", type="text", nullable=true)
     */
    private $mailVueData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \Orca\MailBundle\Entity\MailTblMailType
     *
     * @ORM\ManyToOne(targetEntity="Orca\MailBundle\Entity\MailTblMailType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mail_type_id", referencedColumnName="mail_type_id")
     * })
     */
    private $mailType;

    /**
     * @var \Orca\MailBundle\Entity\MailTblRegle
     * @ORM\ManyToOne(targetEntity="Orca\MailBundle\Entity\MailTblRegle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="regle_id", referencedColumnName="regle_id",nullable=false)
     * })
     */
    private $mailRegle;

    public function __construct(){
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
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
     * Set mailObject
     *
     * @param string $mailObject
     *
     * @return MailTblMail
     */
    public function setMailObject($mailObject)
    {
        $this->mailObject = $mailObject;

        return $this;
    }

    /**
     * Get mailObject
     *
     * @return string
     */
    public function getMailObject()
    {
        return $this->mailObject;
    }

    /**
     * Set mailExpediteur
     *
     * @param string $mailExpediteur
     *
     * @return MailTblMail
     */
    public function setMailExpediteur($mailExpediteur)
    {
        $this->mailExpediteur = $mailExpediteur;

        return $this;
    }

    /**
     * Get mailExpediteur
     *
     * @return string
     */
    public function getMailExpediteur()
    {
        return $this->mailExpediteur;
    }

    /**
     * Set mailDestinataire
     *
     * @param string $mailDestinataire
     *
     * @return MailTblMail
     */
    public function setMailDestinataire($mailDestinataire)
    {
        $this->mailDestinataire = $mailDestinataire;

        return $this;
    }

    /**
     * Get mailDestinataire
     *
     * @return string
     */
    public function getMailDestinataire()
    {
        return $this->mailDestinataire;
    }

    /**
     * Set mailCc
     *
     * @param string $mailCc
     *
     * @return MailTblMail
     */
    public function setMailCc($mailCc)
    {
        $this->mailCc = $mailCc;

        return $this;
    }

    /**
     * Get mailCc
     *
     * @return string
     */
    public function getMailCc()
    {
        return $this->mailCc;
    }

    /**
     * Set mailBcc
     *
     * @param string $mailBcc
     *
     * @return MailTblMail
     */
    public function setMailBcc($mailBcc)
    {
        $this->mailBcc = $mailBcc;

        return $this;
    }

    /**
     * Get mailBcc
     *
     * @return string
     */
    public function getMailBcc()
    {
        return $this->mailBcc;
    }

    /**
     * Set mailBody
     *
     * @param string $mailBody
     *
     * @return MailTblMail
     */
    public function setMailBody($mailBody)
    {
        $this->mailBody = $mailBody;

        return $this;
    }

    /**
     * Get mailBody
     *
     * @return string
     */
    public function getMailBody()
    {
        return $this->mailBody;
    }

    /**
     * Set mailVueData
     *
     * @param string $mailVueData
     *
     * @return MailTblMail
     */
    public function setMailVueData($mailVueData)
    {
        $this->mailVueData = $mailVueData;

        return $this;
    }

    /**
     * Get mailVueData
     *
     * @return string
     */
    public function getMailVueData()
    {
        return $this->mailVueData;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MailTblMail
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MailTblMail
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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

    /**
     * @return MailTblRegle
     */
    public function getMailRegle()
    {
        return $this->mailRegle;
    }

    /**
     * @param MailTblRegle $mailRegle
     */
    public function setMailRegle($mailRegle)
    {
        $this->mailRegle = $mailRegle;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
     * @param string $user_id
     */

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


}