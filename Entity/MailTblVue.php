<?php

namespace Orca\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailTblVue
 *
 * @ORM\Table(name="mail_tbl_vue")
 * @ORM\Entity(repositoryClass="Orca\MailBundle\Repository\MailTblVueRepository")
 */
class MailTblVue
{
    /**
     * @var int
     *
     * @ORM\Column(name="vue_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="vue_lib", type="string", length=64)
     */
    private $vueLib;

    /**
     * @var string
     *
     * @ORM\Column(name="vue_sql_propel", type="text", nullable=true)
     */
    private $vueSqlPropel;

    /**
     * @var string
     *
     * @ORM\Column(name="vue_post_sql_raw", type="text", nullable=true)
     */
    private $vuePostSqlRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="vue_sql_raw", type="text", nullable=true)
     */
    private $vueSqlRaw;

public function __toString(){
    return $this->getVueLib();
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
     * Set vueLib
     *
     * @param string $vueLib
     *
     * @return MailTblVue
     */
    public function setVueLib($vueLib)
    {
        $this->vueLib = $vueLib;

        return $this;
    }

    /**
     * Get vueLib
     *
     * @return string
     */
    public function getVueLib()
    {
        return $this->vueLib;
    }

    /**
     * Set vueSqlPropel
     *
     * @param string $vueSqlPropel
     *
     * @return MailTblVue
     */
    public function setVueSqlPropel($vueSqlPropel)
    {
        $this->vueSqlPropel = $vueSqlPropel;

        return $this;
    }

    /**
     * Get vueSqlPropel
     *
     * @return string
     */
    public function getVueSqlPropel()
    {
        return $this->vueSqlPropel;
    }

    /**
     * Set vuePostSqlRaw
     *
     * @param string $vuePostSqlRaw
     *
     * @return MailTblVue
     */
    public function setVuePostSqlRaw($vuePostSqlRaw)
    {
        $this->vuePostSqlRaw = $vuePostSqlRaw;

        return $this;
    }

    /**
     * Get vuePostSqlRaw
     *
     * @return string
     */
    public function getVuePostSqlRaw()
    {
        return $this->vuePostSqlRaw;
    }

    /**
     * Set vueSqlRaw
     *
     * @param string $vueSqlRaw
     *
     * @return MailTblVue
     */
    public function setVueSqlRaw($vueSqlRaw)
    {
        $this->vueSqlRaw = $vueSqlRaw;

        return $this;
    }

    /**
     * Get vueSqlRaw
     *
     * @return string
     */
    public function getVueSqlRaw()
    {
        return $this->vueSqlRaw;
    }

    /**
     * Get vueSqlRaw
     *
     * @return string
     */
    public function getVueSqlRawLength()
    {
        return substr($this->vueSqlRaw,0,150).' ...';
    }
}

